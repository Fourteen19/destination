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
            'name' => 'Aera 1',
            'display' => 'Y',
            'client_id' => '1',
        ]);

        VacancyRegion::create([
            'name' => 'Aera 2',
            'display' => 'Y',
            'client_id' => '1',
        ]);

        VacancyRegion::create([
            'name' => 'Aera 3',
            'display' => 'Y',
            'client_id' => '1',
        ]);

        VacancyRegion::create([
            'name' => 'Aera 4',
            'display' => 'Y',
            'client_id' => '1',
        ]);

    }
}
