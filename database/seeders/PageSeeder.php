<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //Persists records in DB
        Page::factory()->times(5)->create();

        $this->command->info('Page table seeded!');

    }
}
