<?php

namespace App\Observers;

use App\Models\RelatedVideo;
use Illuminate\Support\Str;

class RelatedVideoObserver
{

    /**
     * Handle the model "creating" event.
     *
     * @param  \App\Models\RelatedVideo $relatedVideo
     * @return void
     */
    public function creating(RelatedVideo $relatedVideo)
    {
        $relatedVideo->uuid = Str::uuid();
    }



    /**
     * Handle the model "created" event.
     *
     * @param  \App\Models\RelatedVideo $relatedVideo
     * @return void
     */
    public function created(RelatedVideo $relatedVideo)
    {
        //
    }

    /**
     * Handle the model "updated" event.
     *
     * @param  \App\Models\RelatedVideo $relatedVideo
     * @return void
     */
    public function updated(RelatedVideo $relatedVideo)
    {
        //
    }

    /**
     * Handle the model "deleted" event.
     *
     * @param  \App\Models\RelatedVideo $relatedVideo
     * @return void
     */
    public function deleted(RelatedVideo $relatedVideo)
    {
        //
    }

    /**
     * Handle the model "restored" event.
     *
     * @param  \App\Models\RelatedVideo $relatedVideo
     * @return void
     */
    public function restored(RelatedVideo $relatedVideo)
    {
        //
    }

    /**
     * Handle the model "force deleted" event.
     *
     * @param  \App\Models\RelatedVideo $relatedVideo
     * @return void
     */
    public function forceDeleted(RelatedVideo $relatedVideo)
    {
        //
    }
}
