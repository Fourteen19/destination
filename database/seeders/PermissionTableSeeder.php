<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'dashboard-view',
            'dashboard-stats-view',
            'profile-edit',
            'admin-list',
            'admin-create',
            'admin-edit',
            'admin-delete',
            'admin-logs-view',
            'client-list',
            'client-create',
            'client-edit',
            'client-delete',
            'client-suspend',
            'institution-list',
            'institution-create',
            'institution-edit',
            'institution-suspend',
            'institution-delete',
            'tag-list',
            'tag-create',
            'tag-edit',
            'tag-delete',
            'global-content-list',
            'global-content-create',
            'global-content-edit',
            'global-content-delete',
            'global-content-make-live',
            'static-content-list',
            'static-content-edit',
            'global-config-edit',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'user-import',
            'user-export',
            'user-data-view',
            'report-list',
            'client-content-list',
            'client-content-create',
            'client-content-edit',
            'client-content-delete',
            'client-content-make-live',
            'client-tag-list',
            'client-tag-create',
            'client-tag-edit',
            'client-tag-delete',
            'vacancy-list',
            'vacancy-create',
            'vacancy-edit',
            'vacancy-delete',
            'event-list',
            'event-create',
            'event-edit',
            'event-delete',
            'resource-list',
            'resource-create',
            'resource-edit',
            'resource-delete',
            'page-list',
            'page-create',
            'page-edit',
            'page-delete',
            'client-settings-edit'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'admin']);
        }

        $this->command->info('Permissions table seeded!');


        $role = Role::create(['name' => 'System Administrator', 'level' => 3, 'guard_name' => 'admin' ]);
        $role->givePermissionTo(
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'dashboard-view',
            'dashboard-stats-view',
            'profile-edit',
            'admin-list',
            'admin-create',
            'admin-edit',
            'admin-delete',
            'admin-logs-view',
            'client-list',
            'client-create',
            'client-edit',
            'client-delete',
            'institution-list',
            'institution-create',
            'institution-edit',
            'institution-suspend',
            'institution-delete',
            'tag-list',
            'tag-create',
            'tag-edit',
            'tag-delete',
            'global-content-list',
            'global-content-create',
            'global-content-edit',
            'global-content-delete',
            'global-content-make-live',
            'static-content-list',
            'static-content-edit',
            'global-config-edit',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'user-import',
            'user-export',
            'user-data-view',
            'report-list',
            'client-content-list',
            'client-content-create',
            'client-content-edit',
            'client-content-delete',
            'client-content-make-live',
            'client-tag-list',
            'client-tag-create',
            'client-tag-edit',
            'client-tag-delete',
            'vacancy-list',
            'vacancy-create',
            'vacancy-edit',
            'vacancy-delete',
            'event-list',
            'event-create',
            'event-edit',
            'event-delete',
            'resource-list',
            'resource-create',
            'resource-edit',
            'resource-delete',
            'page-list',
            'page-create',
            'page-edit',
            'page-delete',
            'client-settings-edit'
        );

        $this->command->info('System Administrator Role created!');


        $role = Role::create(['name' => 'Global Content Admin', 'level' => 3, 'guard_name' => 'admin' ]);
        $role->givePermissionTo(
            'dashboard-view',
            'profile-edit',
            'global-content-list',
            'global-content-create',
            'global-content-edit',
            'global-content-delete',
            'global-content-make-live',
            'static-content-list',
            'static-content-edit',
            'client-content-list',
            'client-content-create',
            'client-content-edit',
            'client-content-delete',
            'client-content-make-live',
            'client-tag-list',
            'client-tag-create',
            'client-tag-edit',
            'client-tag-delete',
            'vacancy-list',
            'vacancy-create',
            'vacancy-edit',
            'vacancy-delete',
            'event-list',
            'event-create',
            'event-edit',
            'event-delete',
            'resource-list',
            'resource-create',
            'resource-edit',
            'resource-delete',
            'page-list',
            'page-create',
            'page-edit',
            'page-delete',
        );

        $this->command->info('Global Content Admin Role created!');


        $role = Role::create(['name' => 'Client Admin', 'level' => 2, 'guard_name' => 'admin' ]);
        $role->givePermissionTo(
            'dashboard-stats-view',
            'profile-edit',
            'admin-list',
            'admin-create',
            'admin-edit',
            'admin-delete',
            'admin-logs-view',
            'institution-list',
            'institution-create',
            'institution-edit',
            'institution-suspend',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'user-import',
            'user-export',
            'user-data-view',
            'report-list',
            'client-content-list',
            'client-content-create',
            'client-content-edit',
            'client-content-delete',
            'client-content-make-live',
            'client-tag-list',
            'client-tag-create',
            'client-tag-edit',
            'client-tag-delete',
            'vacancy-list',
            'vacancy-create',
            'vacancy-edit',
            'vacancy-delete',
            'event-list',
            'event-create',
            'event-edit',
            'event-delete',
            'resource-list',
            'resource-create',
            'resource-edit',
            'resource-delete',
            'page-list',
            'page-create',
            'page-edit',
            'page-delete',
            'client-settings-edit'
        );

        $this->command->info('Client Admin Role created!');



        $role = Role::create(['name' => 'Client Content Admin', 'level' => 2, 'guard_name' => 'admin' ]);
        $role->givePermissionTo(
            'dashboard-view',
            'profile-edit',
            'client-content-list',
            'client-content-create',
            'client-content-edit',
            'client-content-delete',
            'client-content-make-live',
            'vacancy-list',
            'vacancy-create',
            'vacancy-edit',
            'vacancy-delete',
            'event-list',
            'event-create',
            'event-edit',
            'event-delete',
            'resource-list',
            'resource-create',
            'resource-edit',
            'resource-delete',
            'page-list',
            'page-create',
            'page-edit',
            'page-delete',
        );

        $this->command->info('Client Content Admin Role created!');



        $role = Role::create(['name' => 'Advisor', 'level' => 1, 'guard_name' => 'admin' ]);
        $role->givePermissionTo(
            'dashboard-view',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'user-import',
            'user-export',
            'user-data-view',
            'report-list',
            'vacancy-list',
            'vacancy-create',
            'vacancy-edit',
            'vacancy-delete',
            'event-list',
            'event-create',
            'event-edit',
            'event-delete'
        );

        $this->command->info('Advisor Role created!');



        $role = Role::create(['name' => 'Third Party Admin', 'level' => 2, 'guard_name' => 'admin' ]);
        $role->givePermissionTo(
            'dashboard-view',
            'client-content-list',
            'client-content-create',
            'client-content-edit',
            'client-content-delete',
            'vacancy-list',
            'vacancy-create',
            'vacancy-edit',
            'vacancy-delete',
            'event-list',
            'event-create',
            'event-edit',
            'event-delete'
        );

        $this->command->info('Third Party Admin Role created!');



        $this->command->info('Permissions table seeded!');

    }

}
