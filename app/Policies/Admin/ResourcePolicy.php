<?php

namespace App\Policies\Admin;

use App\Models\Content;
use App\Models\Resource;
use App\Models\Admin\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Access\HandlesAuthorization;

class ResourcePolicy
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
        return $admin->hasPermissionTo('resource-list');
    }



    /**
     * Determine if the given model can be created by the user.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function create(Admin $admin)
    {
        return $admin->hasPermissionTo('resource-create');
    }


    /**
     * Determine if the given model can be updated by the user.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function update(Admin $admin, Resource $resource)
    {
        return $admin->hasPermissionTo('resource-edit') && ($this->checkIfAdminCanSeeResource($resource));
    }


    /**
     * Determine if the given model can be deleted by the user.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function delete(Admin $admin, Resource $resource)
    {

        return $admin->hasPermissionTo('resource-delete') && ($this->checkIfAdminCanSeeResource($resource));
    }



    public function checkIfAdminCanSeeResource(Resource $resource)
    {

        $result = False;

        if (isGlobalAdmin())
        {
            $result = TRUE;

        } else {

            //if the resource can be seen by the admin
            if (count($resource->canBeSeenByAdmin) > 0)
            {
                $result = TRUE;
            }

        }

        return $result;

    }

}
