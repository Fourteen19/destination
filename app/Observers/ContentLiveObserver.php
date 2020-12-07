<?php

namespace App\Observers;

use App\Models\ContentLive;


class ContentLiveObserver
{

    /**
     * Handle the institution "creating" event.
     *
     * @param  \App\Models\ContentLive $content
     * @return void
     */
    public function creating(ContentLive $content)
    {

    }



    /**
     * Handle the institution "created" event.
     *
     * @param  \App\Models\ContentLive $content
     * @return void
     */
    public function created(ContentLive $content)
    {
        //
    }

    /**
     * Handle the institution "updated" event.
     *
     * @param  \App\Models\ContentLive $content
     * @return void
     */
    public function updated(ContentLive $content)
    {
        //
    }

    /**
     * Handle the institution "deleted" event.
     *
     * @param  \App\Models\ContentLive $content
     * @return void
     */
    public function deleted(ContentLive $content)
    {
        //
    }

    /**
     * Handle the institution "restored" event.
     *
     * @param  \App\Models\ContentLive $content
     * @return void
     */
    public function restored(ContentLive $content)
    {
        //
    }

    /**
     * Handle the institution "force deleted" event.
     *
     * @param  \App\Models\ContentLive $content
     * @return void
     */
    public function forceDeleted(ContentLive $content)
    {
        //
    }
}
