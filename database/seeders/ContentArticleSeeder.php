<?php

namespace Database\Seeders;

use App\Models\ContentArticle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Factories\ContentFactory;


class ContentArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        ContentArticle::factory()
            ->times(5)
             ->has(ContentFactory::new(['client_id' => NULL])
        )->create();

        ContentArticle::factory()
            ->times(5)
             ->has(ContentFactory::new(['client_id' => 1])
        )->create();

        $this->command->info('Articles seeded!');

    }
}
