<?php

namespace Database\Seeders;

use App\Models\VacancyRegion;
use Illuminate\Database\Seeder;

class VacancyRegionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        VacancyRegion::create([
            'name' => 'Area 1',
            'display' => 'Y',
            'client_id' => '1',
        ]);

        VacancyRegion::create([
            'name' => 'Area 2',
            'display' => 'Y',
            'client_id' => '1',
        ]);

        VacancyRegion::create([
            'name' => 'Area 3',
            'display' => 'Y',
            'client_id' => '1',
        ]);

        VacancyRegion::create([
            'name' => 'Area 4',
            'display' => 'Y',
            'client_id' => '1',
        ]);

    }
}
