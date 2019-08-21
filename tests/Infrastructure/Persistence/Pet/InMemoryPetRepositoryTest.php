<?php
declare(strict_types=1);

namespace Tests\Infrastructure\Persistence\Pet;

use App\Domain\Pet\Pet;
use App\Domain\Pet\PetNotFoundException;
use App\Domain\Pet\Tag;
use App\Infrastructure\Persistence\Pet\InMemoryPetRepository;
use Tests\TestCase;

class InMemoryPetRepositoryTest extends TestCase
{
    public function testFindAll()
    {
        $pet = new Pet(1, 'Doggo', 'available', Pet::CATEGORY_DOG, ['/path'], [new Tag(1, 'lovable')]);

        $petRepository = new InMemoryPetRepository([1 => $pet]);

        $this->assertEquals([$pet], $petRepository->findAll());
    }

    public function testFindUserOfId()
    {
        $pet = new Pet(1, 'Doggo', 'available', Pet::CATEGORY_DOG, ['/path'], [new Tag(1, 'lovable')]);

        $petRepository = new InMemoryPetRepository([1 => $pet]);

        $this->assertEquals($pet, $petRepository->findPetOfId(1));
    }

    /**
     * @expectedException \App\Domain\Pet\PetNotFoundException
     */
    public function testFindUserOfIdThrowsNotFoundException()
    {
        $userRepository = new InMemoryPetRepository([]);
        $userRepository->findPetOfId(1);
    }
}
