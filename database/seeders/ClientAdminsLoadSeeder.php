<?php

namespace Database\Seeders;

use App\Models\Admin\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class ClientAdminsLoadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        //Loops level 2 roles - Client admin
        foreach(Role::where('level', 2)->get() as $role) {

            $admins = Admin::factory()->times(1000)->create();
            foreach($admins as $key => $admin){

                //Persists role
                $admin->assignRole($role);

            }

        }

        $this->command->info('Client Admin table seeded! 1000 of each type');

    }
}
