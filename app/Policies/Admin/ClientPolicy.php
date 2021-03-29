<?php

namespace App\Policies\Admin;

use App\Models\Client;
use App\Models\Admin\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientPolicy
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
     * Determine if institutions can be listed for global and client admins in manage institutions
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function listClientInstitutions(Admin $admin, Client $client)
    {
        return $admin->hasPermissionTo('institution-list') && ($this->checkIfAdminCanSeeClient($client));
    }



    /**
     * Determine if the given model can be listed by the user.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function list(Admin $admin)
    {
        return $admin->hasPermissionTo('client-list');
    }



    /**
     * Determine if the given model can be created by the user.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function create(Admin $admin)
    {
        return $admin->hasPermissionTo('client-create');
    }


    /**
     * Determine if the given model can be updated by the user.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function update(Admin $admin)
    {
        return $admin->hasPermissionTo('client-edit');
    }



    /**
     * Determine if the given model can be deleted by the user.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function delete(Admin $admin)
    {
        return $admin->hasPermissionTo('client-delete');
    }



    /**
     * Determine if the given model can be suspended/unsuspended by the user.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function suspend(Admin $admin)
    {
        return $admin->hasPermissionTo('client-suspend');
    }



    /**
     * Determine if the given model can be suspended/unsuspended by the user.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function branding(Admin $admin)
    {
        return $admin->hasPermissionTo('client-branding');
    }


    public function checkIfAdminCanSeeClient(Client $client)
    {

        $result = False;

        if (isGlobalAdmin())
        {
            $result = TRUE;

        } elseif (isClientAdmin()) {
            //if same client
            if (Auth::guard('admin')->user()->client_id == $client->id)
            {
                $result = TRUE;
            }

        }

        return $result;

    }
}
