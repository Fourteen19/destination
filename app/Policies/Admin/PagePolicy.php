<?php

namespace App\Policies\Admin;

use App\Models\Admin\Admin;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Access\HandlesAuthorization;

class PagePolicy
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
        return $admin->hasPermissionTo('page-list');
    }


    /**
     * Determine if the given model can be created by the user.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function create(Admin $admin)
    {
        return $admin->hasPermissionTo('page-create');
    }


    /**
     * Determine if the given model can be updated by the user.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function update(Admin $admin)
    {
        return $admin->hasPermissionTo('page-edit');
    }


    /**
     * Determine if the given model can be deleted by the user.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function delete(Admin $admin)
    {
        return $admin->hasPermissionTo('page-delete');
    }


    /**
     * Determine if the given model can be made live by the user.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function makeLive(Admin $admin)
    {
        return true;//$admin->hasPermissionTo('page-make-live');
    }

}
