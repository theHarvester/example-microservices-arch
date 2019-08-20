<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\User;

use App\Domain\Pet\Pet;
use App\Domain\Pet\PetNotFoundException;
use App\Domain\Pet\PetRepository;

class InMemoryPetRepository implements PetRepository
{
    /**
     * @var Pet[]
     */
    private $users;

    /**
     * InMemoryUserRepository constructor.
     *
     * @param array|null $users
     */
    public function __construct(array $users = null)
    {
        $this->users = $users ?? [
            1 => new Pet(1, 'bill.gates', 'Bill', 'Gates'),
            2 => new Pet(2, 'steve.jobs', 'Steve', 'Jobs'),
            3 => new Pet(3, 'mark.zuckerberg', 'Mark', 'Zuckerberg'),
            4 => new Pet(4, 'evan.spiegel', 'Evan', 'Spiegel'),
            5 => new Pet(5, 'jack.dorsey', 'Jack', 'Dorsey'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        return array_values($this->users);
    }

    /**
     * {@inheritdoc}
     */
    public function findPetOfId(int $id): Pet
    {
        if (!isset($this->users[$id])) {
            throw new PetNotFoundException();
        }

        return $this->users[$id];
    }
}
