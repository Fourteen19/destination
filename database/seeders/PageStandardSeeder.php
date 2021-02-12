<?php

namespace Database\Seeders;

use App\Models\PageStandard;
use Illuminate\Database\Seeder;
use Database\Factories\PageFactory;

class ContentArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(range(1, 5) as $i) {

            PageStandard::factory()
                    ->has(PageFactory::new(['client_id' => 1, 'title' => 'Some title'])
                )->create(['title' => 'Page '.$i]);

        }

        $this->command->info('Pages seeded!');

    }
}
