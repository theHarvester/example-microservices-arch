<?php
declare(strict_types=1);

namespace App\Domain\Pet;

interface PetRepository
{
    /**
     * @return Pet[]
     */
    public function findAll(): array;

    /**
     * @param int $id
     * @return Pet
     * @throws PetNotFoundException
     */
    public function findPetOfId(int $id): Pet;
}
