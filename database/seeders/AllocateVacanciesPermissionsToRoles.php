<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AllocateVacanciesPermissionsToRoles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //php artisan db:seed --class=AllocateVacanciesPermissionsToRoles

        $permissions = [
            'event-make-live',
            'vacancy-make-live',
            'vacancy-role-list',
            'vacancy-role-create',
            'vacancy-role-edit',
            'vacancy-role-delete',
            'vacancy-region-list',
            'vacancy-region-create',
            'vacancy-region-edit',
            'vacancy-region-delete',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'admin']);
        }

        $role = Role::where('name', 'System Administrator')->first();
        $role->givePermissionTo(
            'event-make-live',
            'employer-list',
            'employer-create',
            'employer-edit',
            'employer-delete',
            'vacancy-edit',
            'vacancy-make-live',
            'vacancy-delete',
            'vacancy-role-list',
            'vacancy-role-create',
            'vacancy-role-edit',
            'vacancy-role-delete',
            'vacancy-region-list',
            'vacancy-region-create',
            'vacancy-region-edit',
            'vacancy-region-delete',
        );



        $role = Role::where('name', 'Global Content Admin')->first();
        $role->givePermissionTo(
            'event-make-live',
            'employer-list',
            'employer-create',
            'employer-edit',
            'employer-delete',
            'vacancy-edit',
            'vacancy-make-live',
            'vacancy-delete',
            'vacancy-role-list',
            'vacancy-role-create',
            'vacancy-role-edit',
            'vacancy-role-delete',
            'vacancy-region-list',
            'vacancy-region-create',
            'vacancy-region-edit',
            'vacancy-region-delete',
        );



        $role = Role::where('name', 'Client Admin')->first();
        $role->givePermissionTo(
            'event-make-live',
            'employer-list',
            'employer-create',
            'employer-edit',
            'employer-delete',
            'vacancy-edit',
            'vacancy-make-live',
            'vacancy-delete',
            'vacancy-role-list',
            'vacancy-role-create',
            'vacancy-role-edit',
            'vacancy-role-delete',
            'vacancy-region-list',
            'vacancy-region-create',
            'vacancy-region-edit',
            'vacancy-region-delete',
        );



        $role = Role::where('name', 'Client Content Admin')->first();
        $role->givePermissionTo(
            'event-make-live',
            'employer-list',
            'employer-create',
            'employer-edit',
            'employer-delete',
            'vacancy-edit',
            'vacancy-make-live',
            'vacancy-delete',
            'vacancy-role-list',
            'vacancy-role-create',
            'vacancy-role-edit',
            'vacancy-role-delete',
            'vacancy-region-list',
            'vacancy-region-create',
            'vacancy-region-edit',
            'vacancy-region-delete',
        );

    }

}
