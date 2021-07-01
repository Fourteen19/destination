<?php

namespace App\Policies\Admin;

use App\Models\Vacancy;
use App\Models\Admin\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class VacancyPolicy
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
        return $admin->hasPermissionTo('vacancy-list');
    }



    /**
     * Determine if the given model can be created by the user.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function create(Admin $admin)
    {
        return $admin->hasPermissionTo('vacancy-create');
    }


    /**
     * Determine if the given model can be updated by the user.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function update(Admin $admin, Vacancy $vacancy)
    {
        return $admin->hasPermissionTo('vacancy-edit') && ($this->checkIfAdminCanSeeVacancy($vacancy));
    }


    /**
     * Determine if the given model can be deleted by the user.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function delete(Admin $admin, Vacancy $vacancy)
    {

        return $admin->hasPermissionTo('vacancy-delete') && ($this->checkIfAdminCanSeeVacancy($vacancy));
    }


    /**
     * Determine if the given model can be made live by the user.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function makeLive(Admin $admin, Vacancy $vacancy)
    {
        return $admin->hasPermissionTo('vacancy-make-live');
        // && ($this->checkIfAdminCanSeeVacancy($vacancy));
    }


    public function checkIfAdminCanSeeVacancy(Vacancy $vacancy)
    {

        $result = False;

        if (isGlobalAdmin())
        {
            $result = TRUE;

        } else {
            //if the resource can be seen by the admin
            if (count($vacancy->canBeSeenByAdmin) > 0)
            {
                $result = TRUE;
            }

        }

        return $result;

    }

}
