<?php

namespace App\Policies\Admin;

use App\Models\Client;
use App\Models\Admin\Admin;
use App\Models\Institution;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class InstitutionPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    /**
     * Determine if the given model can be listed by the user.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function list(Admin $admin)
    {
        return $admin->hasPermissionTo('institution-list');
    }

    /**
     * Determine if the given model can be created by the user.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function create(Admin $admin)
    {
        //dd($admin);
        return $admin->hasPermissionTo('institution-create');
    }


    /**
     * Determine if the given model can be updated by the user.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function update(Admin $admin, Institution $institution)
    {
        return $admin->hasPermissionTo('institution-edit') && ( $this->checkIfAdminCanSeeInstitution($institution) );
    }


    public function updateMyInstitution(Admin $admin, Institution $institution)
    {
        return $this->checkIfAdminIsAllocatedToInstitution($admin, $institution);
    }

    /**
     * Determine if the given model can be deleted by the user.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function delete(Admin $admin, Institution $institution)
    {
        return $admin->hasPermissionTo('institution-delete') && ( $this->checkIfAdminCanSeeInstitution($institution) );
    }

    /**
     * Determine if the given model can be suspended/unsuspended by the user.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function suspend(Admin $admin, Institution $institution)
    {
        return $admin->hasPermissionTo('institution-suspend') && ( $this->checkIfAdminCanSeeInstitution($institution) );
    }


    public function checkIfAdminCanSeeInstitution(Institution $institution)
    {

        $result = False;

        if (isGlobalAdmin())
        {
            $result = TRUE;

        } elseif (isClientAdmin()) {
            //if same client
            if (Auth::guard('admin')->user()->client_id == $institution->client_id)
            {
                $result = TRUE;
            }

        }

        return $result;

    }


    public function checkIfAdminIsAllocatedToInstitution(Admin $admin, Institution $institution)
    {

        $result = False;

        if ($admin->checkInstitutionsIsAllocatedToAdmin($institution->id) )
        {
            $result = True;
        }

        return $result;
    }

}
