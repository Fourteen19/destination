<?php

namespace App\Policies\Admin;

use App\Models\Admin\Admin;
use App\Models\VacancyRegion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class VacancyRegionPolicy
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
        return $admin->hasPermissionTo('vacancy-region-list');
    }



    /**
     * Determine if the given model can be created by the user.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function create(Admin $admin)
    {
        return $admin->hasPermissionTo('vacancy-region-create');
    }


    /**
     * Determine if the given model can be updated by the user.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function update(Admin $admin, VacancyRegion $vacancyRegion)
    {
        return $admin->hasPermissionTo('vacancy-region-edit') && ($this->checkIfAdminCanSeeVacancyRegion($vacancyRegion));
    }


    /**
     * Determine if the given model can be deleted by the user.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function delete(Admin $admin, VacancyRegion $vacancyRegion)
    {

        return $admin->hasPermissionTo('vacancy-region-delete') && ($this->checkIfAdminCanSeeVacancyRegion($vacancyRegion));
    }


    public function checkIfAdminCanSeeVacancyRegion(VacancyRegion $vacancyRegion)
    {

        $result = False;

        if (isGlobalAdmin())
        {
            $result = TRUE;

        } else {

            //if the vacancy region can be seen by the admin
            if  (Auth::guard('admin')->user()->client_id == $vacancyRegion->client_id)
            {
                $result = TRUE;
            }

        }

        return $result;

    }

}
