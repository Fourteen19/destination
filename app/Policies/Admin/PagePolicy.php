<?php

namespace App\Policies\Admin;

use App\Models\Page;
use App\Models\Admin\Admin;
use Illuminate\Support\Facades\Auth;
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
    public function update(Admin $admin, Page $page)
    {
        return $admin->hasPermissionTo('page-edit') && ($this->checkIfAdminCanSeePage($page));
    }


    /**
     * Determine if the given model can be deleted by the user.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function delete(Admin $admin, Page $page)
    {
        return $admin->hasPermissionTo('page-delete') && ($this->checkIfAdminCanSeePage($page));
    }


    /**
     * Determine if the given model can be made live by the user.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function makeLive(Admin $admin)
    {
        return $admin->hasPermissionTo('page-make-live');
    }


    /**
     * Determine if the given model can be reordered by the user.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function reorder(Admin $admin)
    {
        return $admin->hasPermissionTo('page-list');
    }


    public function checkIfAdminCanSeePage(Page $page)
    {

        $result = False;

        if (isGlobalAdmin())
        {
            $result = TRUE;

        } else {

            //if same client
            if  (Auth::guard('admin')->user()->client_id == $page->client_id)
            {
                $result = TRUE;
            }

        }

        return $result;

    }
}
