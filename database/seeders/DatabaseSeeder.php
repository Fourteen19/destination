<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\KeywordSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        if (app()->environment() == 'production') {

            // seeder for production

        } else {

            //seeder for dev
            $this->call([
                GlobalSettingsTableSeeder::class,
                PermissionTableSeeder::class,
                AdminSeeder::class,
                ClientSeeder::class,
                TagsSeeder::class,
                KeywordSeeder::class,
                ContentTemplateSeeder::class,
                ContentArticleSeeder::class,
                PageTemplateSeeder::class,
                PageSeeder::class,
            ]);
        }

    }
}
