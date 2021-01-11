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

        //Loops level 3 roles - Global admin
        foreach(Role::where('level', 3)->get() as $role) {

            $admins = Admin::factory()->times(2)->create();
            foreach($admins as $key => $admin){
                //Persists role
                $admin->assignRole($role);

                $name = ($key == 0) ? 'fred' : 'rick';

                if ($role->name == config('global.admin_user_type.System_Administrator')){
                    $admin->update(['email' => $name.'@rfmedia.co.uk']);
                } elseif ($role->name == config('global.admin_user_type.Global_Content_Admin')){
                    $admin->update(['email' => $name.'_ca@rfmedia.co.uk']);
                }
            }

        }

        //update clients subdomain
/*
        //super admin -- has access to all clients
        DB::table('admins')->where('id', 1)->update(['email' => 'fred@rfmedia.co.uk']);
        DB::table('admins')->where('id', 2)->update(['email' => 'rick@rfmedia.co.uk']);

        //global content admin
        DB::table('admins')->where('id', 4)->update(['email' => 'fred_gca@rfmedia.co.uk']);
        DB::table('admins')->where('id', 5)->update(['email' => 'rick_gca@rfmedia.co.uk']);
*/



        //Loops level 2 roles - Client admin
        foreach(Role::where('level', 2)->get() as $role) {

            $admins = Admin::factory()->times(3)->create();
            foreach($admins as $key => $admin){

                //Persists role
                $admin->assignRole($role);

                $name = ($key == 0) ? 'fred' : 'rick';

                if ($role->name == config('global.admin_user_type.Client_Admin')){
                    $admin->update(['email' => $name.'_ca'.$key.'@rfmedia.co.uk']);
                } elseif ($role->name == config('global.admin_user_type.Client_Content_Admin')){
                    $admin->update(['email' => $name.'_cga'.$key.'@rfmedia.co.uk']);
                } elseif ($role->name == config('global.admin_user_type.Third_Party_Admin')){
                    $admin->update(['email' => $name.'_tpa'.$key.'@rfmedia.co.uk']);
                }

            }

        }



        $this->command->info('Admin table seeded!');

    }
}
