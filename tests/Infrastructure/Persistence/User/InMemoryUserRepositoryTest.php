<?php
declare(strict_types=1);

namespace Tests\Infrastructure\Persistence\User;

use App\Domain\Pet\Pet;
use App\Domain\Pet\PetNotFoundException;
use App\Infrastructure\Persistence\User\InMemoryPetRepository;
use Tests\TestCase;

class InMemoryUserRepositoryTest extends TestCase
{
    public function testFindAll()
    {
        $user = new Pet(1, 'bill.gates', 'Bill', 'Gates');

        $userRepository = new InMemoryPetRepository([1 => $user]);

        $this->assertEquals([$user], $userRepository->findAll());
    }

    public function testFindUserOfId()
    {
        $user = new Pet(1, 'bill.gates', 'Bill', 'Gates');

        $userRepository = new InMemoryPetRepository([1 => $user]);

        $this->assertEquals($user, $userRepository->findPetOfId(1));
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
