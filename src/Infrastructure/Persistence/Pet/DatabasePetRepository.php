<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Pet;

use App\Domain\Pet\Pet;
use App\Domain\Pet\PetNotFoundException;
use App\Domain\Pet\PetRepository;
use App\Domain\Pet\Tag;
use PDO;

class DatabasePetRepository implements PetRepository
{
    /**
     * @var PDO
     */
    private $pdo;

    /**
     * InMemoryUserRepository constructor.
     *
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findPets($statusFilter = null, $idFilter = null)
    {
        $bindings = [];
        $sql = "SELECT p.id, p.name, p.status, p.category, p.photo_urls, t.id as tag_id, t.name as tag_name FROM pets p
LEFT JOIN pet_tags pt on (pt.pet_id = p.id)
LEFT JOIN tags t on (t.id = pt.tag_id) WHERE 1";
        if ($statusFilter !== null) {
            $sql .= " AND status = ?";
            $bindings[] = $statusFilter;
        }
        if ($idFilter !== null) {
            $sql .= " AND p.id = ?";
            $bindings[] = $idFilter;
        }
        $statement = $this->pdo->prepare($sql);
        $statement->execute($bindings);

        $pets = [];
        while ($row = $statement->fetch()) {
            if (array_key_exists($row['id'], $pets)) {
                if ($row['tag_id'] !== null) {
                    $pets[$row['id']]->mergeTag(new Tag($row['tag_id'], $row['tag_name']));
                }
            } else {
                $tags = [];
                if ($row['tag_id'] !== null) {
                    $tags = [new Tag($row['tag_id'], $row['tag_name'])];
                }

                $pets[$row['id']] = new Pet(
                    $row['id'],
                    $row['name'],
                    $row['status'],
                    $row['category'],
                    json_decode($row['photo_urls'], true),
                    $tags
                );
            }
        }
        return $pets;
    }

    /**
     * {@inheritdoc}
     */
    public function findAll($statusFilter = null): array
    {
        $pets = $this->findPets($statusFilter);

        return array_values($pets);
    }

    /**
     * {@inheritdoc}
     */
    public function findPetOfId(int $id): Pet
    {
        $pets = $this->findPets(null, $id);

        if (!isset($pets[$id])) {
            throw new PetNotFoundException();
        }

        return $pets[$id];
    }
}
