<?php

namespace Database\Seeders;

use App\Models\Admin\Admin;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CkAdminsSeeder extends Seeder
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
            'uuid' => $faker->uuid,
            'first_name' => 'Alison',
            'last_name' => 'Shute',
            'email' => 'alison.shute@ckcareers.org.uk',
            'password' => Hash::make('ckcareers'),
        ]);

        $admin = Admin::where('email', 'alison.shute@ckcareers.org.uk')->first();
        $admin->assignRole('System Administrator');

        DB::table('users')->insert([
            'uuid' => $faker->uuid,
            'first_name' => 'Alison',
            'last_name' => 'Shute',
            'email' => 'alison.shute@ckcareers.org.uk',
            'password' => Hash::make('ckcareers'),
            'client_id' => 1,
            'institution_id' => 1,
            'school_year' => 7
        ]);



        ///////////////


        DB::table('admins')->insert([
            'uuid' => $faker->uuid,
            'first_name' => 'Bev',
            'last_name' => 'Baldwin',
            'email' => 'bev.baldwin@ckcareers.org.uk',
            'password' => Hash::make('ckcareers'),
        ]);

        $admin = Admin::where('email', 'bev.baldwin@ckcareers.org.uk')->first();
        $admin->assignRole('System Administrator');

        DB::table('users')->insert([
            'uuid' => $faker->uuid,
            'first_name' => 'Bev',
            'last_name' => 'Baldwin',
            'email' => 'bev.baldwin@ckcareers.org.uk',
            'password' => Hash::make('ckcareers'),
            'client_id' => 1,
            'institution_id' => 1,
            'school_year' => 7
        ]);


        ///////////////


        DB::table('admins')->insert([
            'uuid' => $faker->uuid,
            'first_name' => 'Liz',
            'last_name' => 'Armitage',
            'email' => 'elizabeth.armitage@ckcareers.org.uk',
            'password' => Hash::make('ckcareers'),
        ]);

        $admin = Admin::where('email', 'elizabeth.armitage@ckcareers.org.uk')->first();
        $admin->assignRole('System Administrator');

        DB::table('users')->insert([
            'uuid' => $faker->uuid,
            'first_name' => 'Liz',
            'last_name' => 'Armitage',
            'email' => 'elizabeth.armitage@ckcareers.org.uk',
            'password' => Hash::make('ckcareers'),
            'client_id' => 1,
            'institution_id' => 1,
            'school_year' => 7
        ]);


        ///////////////


        DB::table('admins')->insert([
            'uuid' => $faker->uuid,
            'first_name' => 'Katie',
            'last_name' => 'Wallis',
            'email' => 'katie.wallis@ckcareers.org.uk',
            'password' => Hash::make('ckcareers'),
        ]);

        $admin = Admin::where('email', 'katie.wallis@ckcareers.org.uk')->first();
        $admin->assignRole('System Administrator');

        DB::table('users')->insert([
            'uuid' => $faker->uuid,
            'first_name' => 'Katie',
            'last_name' => 'Wallis',
            'email' => 'katie.wallis@ckcareers.org.uk',
            'password' => Hash::make('ckcareers'),
            'client_id' => 1,
            'institution_id' => 1,
            'school_year' => 7
        ]);


        ///////////////



        DB::table('admins')->insert([
            'uuid' => $faker->uuid,
            'first_name' => 'Sharon',
            'last_name' => 'Tinker',
            'email' => 'sharon.tinker@ckcareers.org.uk',
            'password' => Hash::make('ckcareers'),
        ]);

        $admin = Admin::where('email', 'sharon.tinker@ckcareers.org.uk')->first();
        $admin->assignRole('System Administrator');

        DB::table('users')->insert([
            'uuid' => $faker->uuid,
            'first_name' => 'Sharon',
            'last_name' => 'Tinker',
            'email' => 'sharon.tinker@ckcareers.org.uk',
            'password' => Hash::make('ckcareers'),
            'client_id' => 1,
            'institution_id' => 1,
            'school_year' => 7
        ]);


        ///////////////


        DB::table('admins')->insert([
            'uuid' => $faker->uuid,
            'first_name' => 'Joel',
            'last_name' => 'Robinson',
            'email' => 'Joel.Robinson@ckcareers.org.uk',
            'password' => Hash::make('jumpingtomato'),
        ]);

        $admin = Admin::where('email', 'Joel.Robinson@ckcareers.org.uk')->first();
        $admin->assignRole('System Administrator');

        DB::table('users')->insert([
            'uuid' => $faker->uuid,
            'first_name' => 'Joel',
            'last_name' => 'Robinson',
            'email' => 'Joel.Robinson@ckcareers.org.uk',
            'password' => Hash::make('ckcareers'),
            'client_id' => 1,
            'institution_id' => 1,
            'school_year' => 7
        ]);


        ///////////////


    }
}
