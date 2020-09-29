<?php

namespace App\Observers;

use App\Models\Institution;
use Illuminate\Support\Str;

class InstitutionObserver
{

    /**
     * Handle the institution "creating" event.
     *
     * @param  \App\Models\Institution $institution
     * @return void
     */
    public function creating(Institution $institution)
    {
        $institution->uuid = Str::uuid();
    }

    

    /**
     * Handle the institution "created" event.
     *
     * @param  \App\Models\Institution  $institution
     * @return void
     */
    public function created(Institution $institution)
    {
        //
    }

    /**
     * Handle the institution "updated" event.
     *
     * @param  \App\Models\Institution $institution
     * @return void
     */
    public function updated(Institution $institution)
    {
        //
    }

    /**
     * Handle the institution "deleted" event.
     *
     * @param  \App\Models\Institution $institution
     * @return void
     */
    public function deleted(Institution $institution)
    {
        //
    }

    /**
     * Handle the institution "restored" event.
     *
     * @param  \App\Models\Institution $institution
     * @return void
     */
    public function restored(Institution $institution)
    {
        //
    }

    /**
     * Handle the institution "force deleted" event.
     *
     * @param  \App\Models\Institution $institution
     * @return void
     */
    public function forceDeleted(Institution $institution)
    {
        //
    }
}
