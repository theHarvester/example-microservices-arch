<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Pet;

use App\Domain\Pet\Pet;
use App\Domain\Pet\PetNotFoundException;
use App\Domain\Pet\PetRepository;
use App\Domain\Pet\Tag;

class InMemoryPetRepository implements PetRepository
{
    /**
     * @var Pet[]
     */
    private $pets;

    /**
     * InMemoryUserRepository constructor.
     *
     * @param array|null $pets
     */
    public function __construct(array $pets = null)
    {
        $this->pets = $pets ?? [
            1 => new Pet(1, 'Doggo', 'available', Pet::CATEGORY_DOG, ['/path'], [new Tag(1, 'lovable')]),
            2 => new Pet(2, 'Catto', 'available', Pet::CATEGORY_CAT, ['/path/2'], [new Tag(2, 'scratchy')]),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function findAll($statusFilter = null): array
    {
        return array_values($this->pets);
    }

    /**
     * {@inheritdoc}
     */
    public function findPetOfId(int $id): Pet
    {
        if (!isset($this->pets[$id])) {
            throw new PetNotFoundException();
        }

        return $this->pets[$id];
    }
}
