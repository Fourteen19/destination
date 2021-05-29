<?php

namespace App\Policies\Admin;

use App\Models\Event;
use App\Models\Admin\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
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
        return $admin->hasPermissionTo('event-list');
    }



    /**
     * Determine if the given model can be created by the user.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function create(Admin $admin)
    {
        return $admin->hasPermissionTo('event-create');
    }


    /**
     * Determine if the given model can be updated by the user.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function update(Admin $admin, Event $event)
    {
        return $admin->hasPermissionTo('event-edit') && ($this->checkIfAdminCanSeeEvent($event));
    }


    /**
     * Determine if the given model can be deleted by the user.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function delete(Admin $admin, Event $event)
    {

        return $admin->hasPermissionTo('event-delete') && ($this->checkIfAdminCanSeeEvent($event));
    }


    /**
     * Determine if the given model can be made live by the user.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return boolean
     */
    public function makeLive(Admin $admin, Event $event)
    {
        return $admin->hasPermissionTo('event-make-live');
    }


    public function checkIfAdminCanSeeEvent(Event $event)
    {

        $result = False;

        if (isGlobalAdmin())
        {
            $result = TRUE;

        } else {
            //if the resource can be seen by the admin
            if (count($event->canBeSeenByAdmin) > 0)
            {
                $result = TRUE;
            }

        }

        return $result;

    }

}
