<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Institution;

class InstitutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        //Persists records in DB
        Institution::factory()->times(5)->create();

        $this->command->info('Institution table seeded!');

    }
}
