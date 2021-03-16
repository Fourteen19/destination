<?php

namespace App\Policies\Admin;

use App\Models\Admin\Admin;
use App\Models\SystemKeywordTag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class SystemKeywordTagPolicy
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
     * Determine if the given model can be created by the user.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function list(Admin $admin)
    {
        return $admin->hasPermissionTo('client-keyword-list');
    }

    /**
     * Determine if the given model can be created by the user.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function create(Admin $admin)
    {
        return $admin->hasPermissionTo('client-keyword-create');
    }


    /**
     * Determine if the given model can be updated by the user.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function update(Admin $admin, SystemKeywordTag $keyword)
    {
        return $admin->hasPermissionTo('client-keyword-edit') && ($this->checkIfAdminCanSeeKeyword($keyword));
    }


    /**
     * Determine if the given model can be updated by the user.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function delete(Admin $admin, SystemKeywordTag $keyword)
    {
        return $admin->hasPermissionTo('client-keyword-delete') && ($this->checkIfAdminCanSeeKeyword($keyword));
    }


    public function checkIfAdminCanSeeKeyword(SystemKeywordTag $keyword)
    {

        $result = False;

        if (isGlobalAdmin())
        {
            $result = TRUE;

        } elseif (isClientAdmin()) {
            //if same client
            if (Auth::guard('admin')->user()->client_id == $keyword->client_id)
            {
                $result = TRUE;
            }

        }

        return $result;

    }
}
