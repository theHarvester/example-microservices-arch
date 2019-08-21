<?php
declare(strict_types=1);

namespace App\Domain\Pet;

use JsonSerializable;

class Pet implements JsonSerializable
{
    const CATEGORY_CAT = 0;
    const CATEGORY_DOG = 1;

    /**
     * @var int|null
     */
    private $id;

    /**
     * @var int
     */
    private $categoryId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @param int|null  $id
     * @param string    $username
     * @param string    $firstName
     * @param string    $lastName
     */
    public function __construct(?int $id, string $username, string $firstName, string $lastName)
    {
        $this->id = $id;
        $this->name = $username;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    /**
     * @return int|null
     */
    public function getCategoryId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return strtolower($this->name);
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return ucfirst($this->firstName);
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return ucfirst($this->lastName);
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'username' => $this->name,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
        ];
    }
}
