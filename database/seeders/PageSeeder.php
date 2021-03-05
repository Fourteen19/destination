<?php

namespace Database\Seeders;

use App\Models\PageHomepage;
use App\Models\PageStandard;
use Illuminate\Database\Seeder;
use App\Services\Admin\PageService;
use Database\Factories\PageFactory;

class PageSeeder extends Seeder
{

    protected $pageService;

    /**
      * Create a new controller instance.
      *
      * @return void
    */
    public function __construct(PageService $pageService)
    {

        $this->pageService = $pageService;

    }



    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $homepage = PageHomepage::factory()
            ->has(PageFactory::new(['client_id' => 1, 'title' => 'Homepage', 'template_id' => 1, 'slug' => 'home', 'order_id' => 0
            ])
        )->create(['title' => 'Homepage',
        'banner_title' => 'Welcome to MyDirections',
        'banner_text' => 'Paragraph introducing the concept and talking to teachers and parents about how to get it for your school or child...',
        'banner_link1_text' => 'FIND OUT MORE',
        'banner_link2_text' => 'CONTACT US TO GET MYDIRECTIONS FOR YOUR SCHOOL',
        'free_articles_block_heading' => 'Free sample articles',
        'free_articles_block_text' => 'Here are some examples of the great articles and advice that are available when you are logged in to MyDirections',]);

        $this->pageService->makeLive($homepage->page);

        foreach(range(1, 5) as $i) {

            $page = PageStandard::factory()
                    ->has(PageFactory::new(['client_id' => 1, 'title' => 'standard page title '.$i, 'template_id' => 2, 'order_id' => $i])
                )->create(['title' => 'Page '.$i]);

            $this->pageService->makeLive($page->page);

        }

        $this->command->info('Pages seeded!');

    }
}
