<?php

namespace Database\Seeders;

use App\Models\Admin\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //Persists "Level 3" records in DB
        foreach(Role::where('level', 3)->get() as $role) {

            $admins = Admin::factory()->times(3)->create();
            foreach($admins as $admin){
                $admin->assignRole($role);
             }

        }

        //update clients subdomain

        //super admin -- has access to all clients
        DB::table('admins')->where('id', 1)->update(['email' => 'fred@rfmedia.co.uk']);
        DB::table('admins')->where('id', 2)->update(['email' => 'rick@rfmedia.co.uk']);

        //global content admin
        DB::table('admins')->where('id', 4)->update(['email' => 'fred_gca@rfmedia.co.uk']);
        DB::table('admins')->where('id', 5)->update(['email' => 'rick_gca@rfmedia.co.uk']);


        $this->command->info('Admin table seeded!');

    }
}
