<?php

namespace App\Policies\Admin;

use App\Models\Admin\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class GlobalSettingsPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Determine if the given model can be updated by the user.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function update(Admin $admin)
    {
        return $admin->hasPermissionTo('global-config-edit');
    }

}
