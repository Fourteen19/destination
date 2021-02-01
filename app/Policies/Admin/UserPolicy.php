<?php

namespace App\Policies\Admin;

use App\Models\Admin\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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
     * Determine if the given post can be listed by the user.
     *
     * @param  \App\Models\Admin\Admin $admin
     * @return boolean
     */
    public function list(Admin $admin)
    {
        return $admin->hasPermissionTo('user-list');
    }

    /**
     * Determine if the given post can be created by the user.
     *
     * @param  \App\Models\Admin\Admin $admin
     * @return boolean
     */
    public function create(Admin $admin)
    {
        return $admin->hasPermissionTo('user-create');
    }


    /**
     * Determine if the given model can be updated by the user.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function update(Admin $admin)
    {
        return $admin->hasPermissionTo('user-edit');
    }


    /**
     * Determine if the given model can be deleted by the user.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function delete(Admin $admin)
    {
        return $admin->hasPermissionTo('user-delete');
    }


}
