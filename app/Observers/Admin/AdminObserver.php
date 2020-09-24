<?php

namespace App\Observers\Admin;

use App\Models\Admin\Admin;
use Illuminate\Support\Str;

class AdminObserver
{

    /**
     * Handle the admin "creating" event.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return void
     */
    public function creating(Admin $admin)
    {
        $admin->uuid = Str::uuid();
    }

    

    /**
     * Handle the admin "created" event.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return void
     */
    public function created(Admin $admin)
    {
        //
    }

    /**
     * Handle the admin "updated" event.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return void
     */
    public function updated(Admin $admin)
    {
        //
    }

    /**
     * Handle the admin "deleted" event.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return void
     */
    public function deleted(Admin $admin)
    {
        //
    }

    /**
     * Handle the admin "restored" event.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return void
     */
    public function restored(Admin $admin)
    {
        //
    }

    /**
     * Handle the admin "force deleted" event.
     *
     * @param  \App\Models\Admin\Admin  $admin
     * @return void
     */
    public function forceDeleted(Admin $admin)
    {
        //
    }
}
