<?php

namespace App\Policies\Admin;

use App\Models\Admin\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
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
     * Determine if the given model can be created by the user.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function list(Admin $admin)
    {
        return $admin->hasPermissionTo('admin-list');
    }


    /**
     * Determine if the given model can be created by the user.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function create(Admin $admin)
    {
        return $admin->hasPermissionTo('admin-create');
    }


    /**
     * Determine if the given model can be updated by the user.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function update(Admin $admin)
    {
        return $admin->hasPermissionTo('admin-edit');
    }



    /**
     * Determine if the given model can be deleted by the user.
     *
     * @param  mixed $admin
     * @param  mixed $adminToBeDeleted
     * @return void
     */
    public function delete(Admin $admin, Admin $adminToBeDeleted)
    {

        $permission = $admin->hasPermissionTo('admin-delete');

        if ($permission)
        {

            //if the loged in user is a system admin
            if (isGlobalAdmin()) {

                $permission = True;

            //if the loged in user is a client admin
            } elseif (isClientAdmin()){

                //if the logged in user's client ID is the same as the deleted user's client ID
                $permission = ($adminToBeDeleted->client_id == Auth::guard('admin')->user()->client_id) ? True : False;

            //if the loged in user is a system admin
            } else {

                $permission = False;

            }

        }

        return $permission;

    }

}
