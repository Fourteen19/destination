<?php

namespace Database\Seeders;

use App\Models\ContentArticle;
use Illuminate\Database\Seeder;
use Database\Factories\VideoFactory;
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
                    ->has(ContentFactory::new(['client_id' => NULL, 'title' => 'Article '.$i])
                    ->has(VideoFactory::new()->times(2))
                    ->has(RelatedLinkFactory::new()->times(2))
                    ->has(RelatedDownloadFactory::new()->times(3))
                )->create(['title' => 'Article '.$i, 'summary_heading' => 'Article '.$i]);
        

            ContentArticle::factory()
                    ->has(ContentFactory::new(['client_id' => 1, 'title' => 'Article '.$i])
                    ->has(VideoFactory::new()->times(2))
                    ->has(RelatedLinkFactory::new()->times(2))
                    ->has(RelatedDownloadFactory::new()->times(3))
                )->create(['title' => 'Article '.$i, 'summary_heading' => 'Article '.$i]);
        
        }

        $this->command->info('Articles seeded!');

    }
}
