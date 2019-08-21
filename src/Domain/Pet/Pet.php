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
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $category;

    /**
     * @var string[]
     */
    private $photoUrls;

    /**
     * @var string
     */
    private $status;

    /**
     * @var Tag[]
     */
    private $tags;

    /**
     * @param int|null $id
     * @param string $name
     * @param string $status
     * @param int $category
     * @param array $photoUrls
     * @param Tag[] $tags
     */
    public function __construct(?int $id, string $name, string $status, int $category, array $photoUrls, array $tags)
    {
        $this->id = $id;
        $this->name = $name;
        $this->status = $status;
        $this->category = $category;
        $this->photoUrls = $photoUrls;
        $this->tags = $tags;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getCategory(): int
    {
        return $this->category;
    }

    /**
     * @return string[]
     */
    public function getPhotoUrls(): array
    {
        return $this->photoUrls;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return array
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    public function mergeTag(Tag $tag)
    {
        return $this->tags[] = $tag;
    }

    public function getCategoryLabel($categoryType)
    {
        switch ($categoryType) {
            case self::CATEGORY_CAT:
                return 'cat';
            case self::CATEGORY_DOG:
                return 'dog';
            default:
                return '';
        }
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'category' => [
                'id' => $this->category,
                'name' => $this->getCategoryLabel($this->category)
            ],
            'name' => $this->name,
            'photoUrls' => $this->photoUrls,
            'tags' => array_map(function(Tag $tag) {
                return $tag->jsonSerialize();
            }, $this->tags),
            'status' => $this->status,
        ];
    }
}
