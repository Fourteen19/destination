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
        ]);

        ContentTemplate::create([
            'name' => 'Accordion',
            'description' => 'This template allows to add an accordion',
            'image' => '',
        ]);

        ContentTemplate::create([
            'name' => 'Poll',
            'description' => 'This template allows to add a poll',
            'image' => '',
        ]);

        ContentTemplate::create([
            'name' => 'Activity',
            'description' => 'This template allows to add an activity',
            'image' => '',
        ]);

    }
}
