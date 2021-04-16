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
            'show' => 'Y',
            'slug' => 'article',
            'slug_plural' => 'articles'
        ]);

        ContentTemplate::create([
            'name' => 'Accordion',
            'description' => 'This template allows to add an accordion',
            'image' => '',
            'show' => 'Y',
            'slug' => 'accordion',
            'slug_plural' => 'accordions'
        ]);

        ContentTemplate::create([
            'name' => 'Work Experience Activity',
            'description' => 'This template allows to add an activity',
            'image' => '',
            'show' => 'Y',
            'slug' => 'activity',
            'slug_plural' => 'activities'
        ]);

        ContentTemplate::create([
            'name' => 'Employer Profile',
            'description' => "This template allows to add an employer's profile",
            'image' => '',
            'show' => 'Y',
            'slug' => 'employer',
            'slug_plural' => 'employers'
        ]);

    }
}
