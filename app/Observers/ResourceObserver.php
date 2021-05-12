<?php

namespace App\Observers;

use App\Models\Resource;
use Illuminate\Support\Str;

class ResourceObserver
{

    /**
     * Handle the institution "creating" event.
     *
     * @param  \App\Models\Resource $resource
     * @return void
     */
    public function creating(Resource $resource)
    {
        $resource->uuid = Str::uuid();
    }



    /**
     * Handle the institution "created" event.
     *
     * @param  \App\Models\Resource $resource
     * @return void
     */
    public function created(Resource $resource)
    {
        //
    }

    /**
     * Handle the institution "updated" event.
     *
     * @param  \App\Models\Resource $resource
     * @return void
     */
    public function updated(Resource $resource)
    {
        //
    }

    /**
     * Handle the institution "deleted" event.
     *
     * @param  \App\Models\Resource $resource
     * @return void
     */
    public function deleted(Resource $resource)
    {
        //
    }

    /**
     * Handle the institution "restored" event.
     *
     * @param  \App\Models\Resource $resource
     * @return void
     */
    public function restored(Resource $resource)
    {
        //
    }

    /**
     * Handle the institution "force deleted" event.
     *
     * @param  \App\Models\Resource $resource
     * @return void
     */
    public function forceDeleted(Resource $resource)
    {
        //
    }
}
