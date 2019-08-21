<?php
declare(strict_types=1);

namespace Tests\Infrastructure\Persistence\Pet;

use App\Domain\Pet\Pet;
use App\Domain\Pet\PetNotFoundException;
use App\Domain\Pet\Tag;
use App\Infrastructure\Persistence\Pet\DatabasePetRepository;
use App\Infrastructure\Persistence\Pet\InMemoryPetRepository;
use Prophecy\Prophecy\MethodProphecy;
use Tests\TestCase;

class DatabasePetRepositoryTest extends TestCase
{
    public function testFindPets()
    {
        // TODO I'm going a little light on these tests but this is roughly the idea, you'd want full coverage in a real setting though

        $statementProphesy = $this->prophesize(\PDOStatement::class);
        $statementProphesy->execute([])->willReturn(null);
        $statementProphesy->fetch()->willReturn([
            'id' => 1,
            'name' => 'Doggie',
            'status' => 'available',
            'category' => Pet::CATEGORY_CAT,
            'photo_urls' => '["/path"]',
            'tag_id' => 10,
            'tag_name' => 'hello',
        ], [
            'id' => 1,
            'name' => 'Doggie',
            'status' => 'available',
            'category' => Pet::CATEGORY_CAT,
            'photo_urls' => '["/path"]',
            'tag_id' => 11,
            'tag_name' => 'bye',
        ], null);

        $pdoProphesy = $this->prophesize(\PDO::class);
        $sql = "SELECT p.id, p.name, p.status, p.category, p.photo_urls, t.id as tag_id, t.name as tag_name FROM pets p
LEFT JOIN pet_tags pt on (pt.pet_id = p.id)
LEFT JOIN tags t on (t.id = pt.tag_id) WHERE 1";
        $pdoProphesy->prepare($sql)->willReturn($statementProphesy->reveal());

        $repo = new DatabasePetRepository($pdoProphesy->reveal());
        $pets = $repo->findPets();

        $this->assertEquals(1, $pets[1]->getId());
        $this->assertCount(2, $pets[1]->getTags());
    }
}
