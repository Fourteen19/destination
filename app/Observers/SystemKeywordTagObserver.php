<?php

namespace App\Observers;

use App\Models\SystemKeywordTag;
use Illuminate\Support\Str;

class SystemKeywordTagObserver
{

    /**
     * Handle the tag "creating" event.
     *
     * @param  \App\Models\SystemKeywordTag $tag
     * @return void
     */
    public function creating(SystemKeywordTag $tag)
    {
        $tag->uuid = Str::uuid();
    }



    /**
     * Handle the tag "created" event.
     *
     * @param  \App\Models\SystemKeywordTag  $tag
     * @return void
     */
    public function created(SystemKeywordTag $tag)
    {
        //
    }

    /**
     * Handle the tag "updated" event.
     *
     * @param  \App\Models\SystemKeywordTag $tag
     * @return void
     */
    public function updated(SystemKeywordTag $tag)
    {
        //
    }

    /**
     * Handle the tag "deleted" event.
     *
     * @param  \App\Models\SystemKeywordTag $tag
     * @return void
     */
    public function deleted(SystemKeywordTag $tag)
    {
        //
    }

    /**
     * Handle the tag "restored" event.
     *
     * @param  \App\Models\SystemKeywordTag $tag
     * @return void
     */
    public function restored(SystemKeywordTag $tag)
    {
        //
    }

    /**
     * Handle the tag "force deleted" event.
     *
     * @param  \App\Models\SystemKeywordTag $tag
     * @return void
     */
    public function forceDeleted(SystemKeywordTag $tag)
    {
        //
    }
}
