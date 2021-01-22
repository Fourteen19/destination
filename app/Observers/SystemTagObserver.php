<?php

namespace App\Observers;

use App\Models\SystemTag;
use Illuminate\Support\Str;

class SystemTagObserver
{

    /**
     * Handle the tag "creating" event.
     *
     * @param  \App\Models\SystemTag $tag
     * @return void
     */
    public function creating(SystemTag $tag)
    {
        $tag->uuid = Str::uuid();
    }



    /**
     * Handle the tag "created" event.
     *
     * @param  \App\Models\SystemTag  $tag
     * @return void
     */
    public function created(SystemTag $utagser)
    {
        //
    }

    /**
     * Handle the tag "updated" event.
     *
     * @param  \App\Models\SystemTag $tag
     * @return void
     */
    public function updated(SystemTag $tag)
    {
        //
    }

    /**
     * Handle the tag "deleted" event.
     *
     * @param  \App\Models\SystemTag $tag
     * @return void
     */
    public function deleted(SystemTag $tag)
    {
        //
    }

    /**
     * Handle the tag "restored" event.
     *
     * @param  \App\Models\SystemTag $tag
     * @return void
     */
    public function restored(SystemTag $tag)
    {
        //
    }

    /**
     * Handle the tag "force deleted" event.
     *
     * @param  \App\Models\SystemTag $tag
     * @return void
     */
    public function forceDeleted(SystemTag $tag)
    {
        //
    }
}
