<?php

namespace App\Policies\Admin;

use App\Models\User;
use App\Models\Admin\Admin;
use Illuminate\Support\Facades\Auth;
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
    public function update(Admin $admin, User $user)
    {
        return $admin->hasPermissionTo('user-edit') && ( $this->checkIfAdminCanSeeUser($user) );
    }


    /**
     * Determine if the given model can be deleted by the user.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function delete(Admin $admin, User $user)
    {
        return $admin->hasPermissionTo('user-delete') && ( $this->checkIfAdminCanSeeUser($user) );
    }



    /**
     * Determine if the given model can be deleted by the user.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function viewData(Admin $admin, User $user)
    {
        return $admin->hasPermissionTo('user-data-view') && ( $this->checkIfAdminCanSeeUser($user) );
    }




    public function checkIfAdminCanSeeUser(User $user)
    {

        $result = False;

        if (isGlobalAdmin())
        {
            $result = TRUE;

        } elseif (isClientAdmin()) {
            //if same client
            if (Auth::guard('admin')->user()->client_id == $user->client_id)
            {
                $result = TRUE;
            }

        } else if (isClientAdvisor()) {

            //if same client &&
            //if has right to see institution
            if ( (Auth::guard('admin')->user()->client_id == $user->client_id) &&
            (in_array($user->institution_id, Auth::guard('admin')->user()->compileInstitutionsToArray()) ) )
            {
                $result = TRUE;
            }

        }

        return $result;

    }

}
