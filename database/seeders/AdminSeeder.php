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

        DB::table('admins')->insert([
            'first_name' => $faker->firstNameMale,
            'last_name' => $faker->lastName,
            'email' => 'fred@gmail.com',
            'password' => Hash::make('password'),
        ]);
    }
}
