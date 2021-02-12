<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageTemplate;

class ContentTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        PageTemplate::create([
            'name' => 'Homepage',
            'description' => 'This template allows to add a homepage',
            'image' => '',
            'show' => 'N',
            'slug' => 'homepage',
            'slug_plural' => 'homepages'
        ]);

        PageTemplate::create([
            'name' => 'Standard',
            'description' => 'This template allows to add aa standard page',
            'image' => '',
            'show' => 'Y',
            'slug' => 'standard',
            'slug_plural' => 'standards'
        ]);
/*
        ContentTemplate::create([
            'name' => 'Poll',
            'description' => 'This template allows to add a poll',
            'image' => '',
            'slug' => 'poll',
            'slug_plural' => 'polls'
        ]);
*/

    }
}
