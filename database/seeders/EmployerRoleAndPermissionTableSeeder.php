<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class EmployerRoleAndPermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'employer-list',
            'employer-create',
            'employer-edit',
            'employer-delete',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'admin']);
        }

        $this->command->info('Permissions table seeded!');


        $role = Role::create(['name' => 'Employer', 'level' => 0, 'guard_name' => 'admin' ]);
        $role->givePermissionTo(
            'vacancy-list',
            'vacancy-create',
            'vacancy-edit',
        );

        $this->command->info('Employer Role created!');

    }

}
