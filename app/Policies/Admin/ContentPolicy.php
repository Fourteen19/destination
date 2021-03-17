<?php

namespace App\Policies\Admin;

use App\Models\Content;
use App\Models\Admin\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContentPolicy
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
     * Determine if the given model can be listed by the user.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function list(Admin $admin)
    {
        if (Route::is('admin.global*'))
        {
            $prefix = "global";
        } else {
            $prefix = "client";
        }
        return $admin->hasPermissionTo($prefix.'-content-list');
    }



    /**
     * Determine if the given model can be created by the user.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function create(Admin $admin)
    {
        if (Route::is('admin.global*'))
        {
            $prefix = "global";
        } else {
            $prefix = "client";
        }
        return $admin->hasPermissionTo($prefix.'-content-create');
    }


    /**
     * Determine if the given model can be updated by the user.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function update(Admin $admin, Content $content)
    {
        if (Route::is('admin.global*'))
        {
            $prefix = "global";
        } else {
            $prefix = "client";
        }
        return $admin->hasPermissionTo($prefix.'-content-edit') && ($this->checkIfAdminCanSeeContent($content));
    }


    /**
     * Determine if the given model can be deleted by the user.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function delete(Admin $admin, Content $content)
    {
        if (Route::is('admin.global*'))
        {
            $prefix = "global";
        } else {
            $prefix = "client";
        }
        return $admin->hasPermissionTo($prefix.'-content-delete') && ($this->checkIfAdminCanSeeContent($content));
    }


    /**
     * Determine if the given model can be made live by the user.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function makeLive(Admin $admin, Content $content)
    {
        if (Route::is('admin.global*'))
        {
            $prefix = "global";
        } else {
            $prefix = "client";
        }
        return $admin->hasPermissionTo($prefix.'-content-make-live') && ($this->checkIfAdminCanSeeContent($content));
    }


    public function checkIfAdminCanSeeContent(Content $content)
    {

        $result = False;

        if (isGlobalAdmin())
        {
            $result = TRUE;

        } elseif (isClientAdmin()) {
            //if same client
            if (Auth::guard('admin')->user()->client_id == $content->client_id)
            {
                $result = TRUE;
            }

        }

        return $result;

    }

}
