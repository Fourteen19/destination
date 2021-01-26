<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SystemKeywordTag;

class KeywordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->command->info('Keywords Tags Table seeding starts!');

        $keywords = [
            [
                'name' => 'Maths'
            ],
            [
                'name' => 'Marketing'
            ],
            [
                'name' => 'Master degree'
            ],
            [
                'name' => 'English'
            ],
            [
                'name' => 'Higher Education'
            ],
            [
                'name' => 'Healthcare'
            ],
            [
                'name' => 'Apprenticeships'
            ],
            [
                'name' => 'Business'
            ],
            [
                'name' => 'Computing and IT'
            ],
            [
                'name' => 'Other'
            ]
        ];


        $TagsTypes = ['keyword'];

        foreach($TagsTypes as $tagsType)
        {

            if ($tagsType == "keyword")
            {
                $items = $keywords;
            }


            foreach($items as $item)
            {
                $this->createTag($tagsType, $item, 1);
            }

            $this->command->info($tagsType.' Tags created!');

        }

        $this->command->info('Keywords Tags Table seeded!');

    }

    /**
     *
     * Creates the tag in the DB
     *
     */
    public function createTag($tagsType, $item, $clientId)
    {

        SystemKeywordTag::create([
            'name' => $item['name'],
            'text' => isset($item['text']) ? $item['text'] : NULL,
            'type' => $tagsType,
            'live' => 'Y',
            'client_id' => $clientId
       ]);

    }

}
