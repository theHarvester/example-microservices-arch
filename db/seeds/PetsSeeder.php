<?php


use Phinx\Seed\AbstractSeed;

class PetsSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $mittensId = rand(1, 1000);
        $scruffyId = rand(1, 1000);

        $data = [
            [
                'id' => $mittensId,
                'name' => 'Mittens',
                'status' => \App\Domain\Pet\Pet::CATEGORY_CAT,
                'photo_urls' => '["/url/to/photo"]',
                'created' => date('Y-m-d H:i:s'),
                'updated' => date('Y-m-d H:i:s'),
            ], [
                'id' => $scruffyId,
                'name' => 'Scruffy',
                'status' => \App\Domain\Pet\Pet::CATEGORY_DOG,
                'photo_urls' => '["/url/to/photo"]',
                'created' => date('Y-m-d H:i:s'),
                'updated' => date('Y-m-d H:i:s'),
            ]
        ];

        $posts = $this->table('pets');
        $posts->insert($data)->save();

        $playfulId = rand(1, 1000);
        $meanId = rand(1, 1000);
        $data = [
            [
                'id' => $playfulId,
                'name' => 'playful',
            ], [
                'id' => $meanId,
                'name' => 'mean',
            ]
        ];

        $posts = $this->table('tags');
        $posts->insert($data)->save();

        $playfulId = rand(1, 1000);
        $meanId = rand(1, 1000);
        $data = [
            [
                'pet_id' => $scruffyId,
                'tag_id' => $playfulId,
            ], [
                'pet_id' => $mittensId,
                'tag_id' => $meanId,
            ]
        ];

        $posts = $this->table('pet_tags');
        $posts->insert($data)->save();
    }
}
