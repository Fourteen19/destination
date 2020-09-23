<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\Institution;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //Persists records in DB
        Client::factory()
            ->times(5)
            ->has(Institution::factory()->count(3))
            ->create();
        
        $this->command->info('Client table seeded!');

    }
}
