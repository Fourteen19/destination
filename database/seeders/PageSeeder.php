<?php

namespace Database\Seeders;

use App\Models\PageHomepage;
use App\Models\PageStandard;
use Illuminate\Database\Seeder;
use Database\Factories\PageFactory;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        PageHomepage::factory()
            ->has(PageFactory::new(['client_id' => 1, 'title' => 'Homepage'])
        )->create(['title' => 'Homepage']);

        foreach(range(1, 5) as $i) {

            PageStandard::factory()
                    ->has(PageFactory::new(['client_id' => 1, 'title' => 'standard page title '.$i])
                )->create(['title' => 'Page '.$i]);

        }

        $this->command->info('Pages seeded!');

    }
}
