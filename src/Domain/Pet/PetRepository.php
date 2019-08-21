<?php
declare(strict_types=1);

namespace App\Domain\Pet;

interface PetRepository
{
    /**
     * @param string|null $statusFilter
     * @return Pet[]
     */
    public function findAll($statusFilter = null): array;

    /**
     * @param int $id
     * @return Pet
     * @throws PetNotFoundException
     */
    public function findPetOfId(int $id): Pet;
}
