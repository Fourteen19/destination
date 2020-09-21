<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Faker\Factory as Faker;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1,200) as $index) {       

            DB::table('admins')->insert([
                'uuid' => $faker->uuid,
                'first_name' => $faker->firstNameMale,
                'last_name' => $faker->lastName,
                'email' => 'fred'.$index.'@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'system_admin'
            ]);
        
            DB::table('admins')->insert([
                'uuid' => $faker->uuid,
                'first_name' => $faker->firstNameMale,
                'last_name' => $faker->lastName,
                'email' => 'fred_admin'.$index.'@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'admin'
            ]);
            }

            DB::table('admins')->insert([
                'uuid' => $faker->uuid,
                'first_name' => $faker->firstNameMale,
                'last_name' => $faker->lastName,
                'email' => 'fred_editor'.$index.'@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'editor'
            ]);
        }
    }
}
