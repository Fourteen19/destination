<?php

namespace Database\Seeders;

use App\Models\ContentArticle;
use Illuminate\Database\Seeder;
use Database\Factories\RelatedVideoFactory;
use Database\Factories\ContentFactory;
use Database\Factories\RelatedLinkFactory;
use Database\Factories\RelatedDownloadFactory;


class ContentArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(range(1, 10) as $i) {

            ContentArticle::factory()
                    ->has(ContentFactory::new(['client_id' => NULL, 'title' => 'Global Article '.$i, 'summary_heading' => 'Global Article '.$i, 'summary_text' => 'Summary text for Article '.$i])
                    ->has(RelatedVideoFactory::new()->times(2))
                    ->has(RelatedLinkFactory::new()->times(2))
                    ->has(RelatedDownloadFactory::new()->times(3))
                )->create(['title' => 'Global Article '.$i]);


            ContentArticle::factory()
                    ->has(ContentFactory::new(['client_id' => 1, 'title' => 'Client Article '.$i, 'summary_heading' => 'Client Article '.$i, 'summary_text' => 'Summary text for Article '.$i])
                    ->has(RelatedVideoFactory::new()->times(2))
                    ->has(RelatedLinkFactory::new()->times(2))
                    ->has(RelatedDownloadFactory::new()->times(3))
                )->create(['title' => 'Client Article '.$i]);

        }

        $this->command->info('Articles seeded!');

    }
}
