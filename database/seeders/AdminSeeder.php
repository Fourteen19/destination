<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin\Admin;
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

        $this->command->info('Admin table seeded!');
       
    }
}
