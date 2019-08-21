<?php
declare(strict_types=1);

namespace Tests\Domain\User;

use App\Domain\Pet\Pet;
use App\Domain\Pet\Tag;
use Tests\TestCase;

class PetTest extends TestCase
{
    public function petProvider()
    {
        return [
            [1, 'Doggo', 'available', Pet::CATEGORY_DOG, ['/path'], [new Tag(1, 'lovable')]],
            [2, 'Doggo1', 'unvailable', Pet::CATEGORY_CAT, ['/path'], [new Tag(1, 'lovable')]],
            [3, 'Doggo2', 'available', Pet::CATEGORY_DOG, ['/path2'], [new Tag(1, 'lovable')]],
            [4, 'Doggo3', 'available', Pet::CATEGORY_DOG, ['/path'], [new Tag(3, 'foo')]],
        ];
    }


    /**
     * @dataProvider petProvider
     * @param $id
     * @param $name
     * @param $status
     * @param $category
     * @param $photoUrls
     * @param $tags
     */
    public function testGetters($id, $name, $status, $category, $photoUrls, $tags)
    {
        $pet = new Pet($id, $name, $status, $category, $photoUrls, $tags);

        $this->assertEquals($id, $pet->getId());
        $this->assertEquals($name, $pet->getName());
        $this->assertEquals($status, $pet->getStatus());
        $this->assertEquals($category, $pet->getCategory());
        $this->assertEquals($photoUrls, $pet->getPhotoUrls());
        $this->assertEquals($tags, $pet->getTags());
    }

    public function serializeProvider()
    {
        return [
            [1, 'Doggo', 'available', Pet::CATEGORY_DOG, ['/path'], [new Tag(1, 'lovable')], 'dog', [['id' => 1, 'name' => 'lovable']]],
            [2, 'Doggo1', 'unvailable', Pet::CATEGORY_CAT, ['/path'], [new Tag(1, 'lovable')], 'cat', [['id' => 1, 'name' => 'lovable']]],
            [3, 'Doggo2', 'available', Pet::CATEGORY_DOG, ['/path2'], [new Tag(1, 'lovable')], 'dog', [['id' => 1, 'name' => 'lovable']]],
            [4, 'Doggo3', 'available', Pet::CATEGORY_DOG, ['/path'], [new Tag(3, 'foo')], 'dog', [['id' => 3, 'name' => 'foo']]],
        ];
    }

    /**
     * @dataProvider serializeProvider
     * @param $id
     * @param $name
     * @param $status
     * @param $category
     * @param $categoryLabel
     * @param $photoUrls
     * @param $tags
     * @param $expectedTags
     */
    public function testSerialize($id, $name, $status, $category, $photoUrls, $tags, $categoryLabel, $expectedTags)
    {
        $pet = new Pet($id, $name, $status, $category, $photoUrls, $tags);

        $expectedPayload = json_encode([
            'id' => $id,
            'category' => [
                'id' => $category,
                'name' => $categoryLabel
            ],
            'name' => $name,
            'photoUrls' => $photoUrls,
            'tags' => $expectedTags,
            'status' => $status,
        ]);

        $this->assertEquals($expectedPayload, json_encode($pet));
    }
}
