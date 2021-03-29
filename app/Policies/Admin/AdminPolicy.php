<?php

namespace App\Policies\Admin;

use App\Models\Admin\Admin;
use Illuminate\Support\Facades\Auth;
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
    public function update(Admin $admin, Admin $adminToEdited)
    {
        return $admin->hasPermissionTo('admin-edit') && ($this->checkIfAdminCanSeeAdmin($adminToEdited));
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
        return $admin->hasPermissionTo('admin-delete') && ($this->checkIfAdminCanSeeAdmin($adminToBeDeleted));
    }


    public function checkIfAdminCanSeeAdmin(Admin $admin)
    {

        $result = False;

        if (isGlobalAdmin())
        {
            $result = TRUE;

        } else {
            //if same client
            if (Auth::guard('admin')->user()->client_id == $admin->client_id)
            {
                $result = TRUE;
            }

        }

        return $result;

    }


}
