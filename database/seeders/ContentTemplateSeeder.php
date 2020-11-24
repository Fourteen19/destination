<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ContentTemplate;

class ContentTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        ContentTemplate::create([
            'name' => 'Article',
            'description' => 'This template allows to add an article',
            'image' => '',
            'slug' => 'article',
            'slug_plural' => 'articles'
        ]);

        ContentTemplate::create([
            'name' => 'Accordion',
            'description' => 'This template allows to add an accordion',
            'image' => '',
            'slug' => 'accordion',
            'slug_plural' => 'accordions'
        ]);

        ContentTemplate::create([
            'name' => 'Poll',
            'description' => 'This template allows to add a poll',
            'image' => '',
            'slug' => 'poll',
            'slug_plural' => 'polls'
        ]);

        ContentTemplate::create([
            'name' => 'Activity',
            'description' => 'This template allows to add an activity',
            'image' => '',
            'slug' => 'activity',
            'slug_plural' => 'activities'
        ]);

    }
}
