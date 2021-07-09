<?php

namespace App\Policies\Admin;

use App\Models\Vacancy;
use App\Models\Admin\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
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
        return $admin->hasPermissionTo('vacancy-edit') && ($this->checkIfAdminCanSeeVacancy($admin, $vacancy));
    }


    /**
     * Determine if the given model can be deleted by the user.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function delete(Admin $admin, Vacancy $vacancy)
    {

        return $admin->hasPermissionTo('vacancy-delete') && ($this->checkIfAdminCanSeeVacancy($admin, $vacancy));
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


    public function checkIfAdminCanSeeVacancy(Admin $admin,Vacancy $vacancy)
    {

        $result = False;

        if (isGlobalAdmin())
        {
            $result = TRUE;

        } elseif (isClientAdmin()) {

            if ($vacancy->checkIfVacanyIsAccessibleForclient(Session::get('adminClientSelectorSelected')) > 0)
            {
                $result = TRUE;
            }

        } elseif (isEmployer($admin)) {

            //if the vacancy is accessible by this client
            //and if the vancancy was created by this employer
            if (  ($vacancy->created_by == Auth::guard('admin')->user()->id) )
            {

                $result = TRUE;

            }

        } else {

            return FALSE;

        }

        return $result;

    }

}
