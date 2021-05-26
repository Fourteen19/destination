<?php

namespace Database\Seeders;

use App\Models\VacancyRole;
use Illuminate\Database\Seeder;

class VacancyRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        VacancyRole::create([
            'name' => 'Apprenticeship',
            'display' => 'Y',
        ]);

        VacancyRole::create([
            'name' => 'Full-time employment',
            'display' => 'Y',
        ]);

        VacancyRole::create([
            'name' => 'Part-time employment',
            'display' => 'Y',
        ]);

        VacancyRole::create([
            'name' => 'Training',
            'display' => 'Y',
        ]);

    }
}
