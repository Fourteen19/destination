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

            $admins = Admin::factory()->times(100)->create();
            foreach($admins as $key => $admin){

                //Persists role
                $admin->assignRole($role);

                $admin->client_id = 1;

                $admin->institutions()->sync(1);

                $admin->save();
            }

        }

        $this->command->info('Client Admin table seeded! 1000 of each client type created');

    }
}
