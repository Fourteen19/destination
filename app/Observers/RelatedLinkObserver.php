<?php

namespace App\Observers;

use App\Models\RelatedLink;
use Illuminate\Support\Str;

class RelatedLinkObserver
{

    /**
     * Handle the model "creating" event.
     *
     * @param  \App\Models\RelatedLink $relatedLink
     * @return void
     */
    public function creating(RelatedLink $relatedLink)
    {
        $relatedLink->uuid = Str::uuid();
    }



    /**
     * Handle the model "created" event.
     *
     * @param  \App\Models\RelatedLink $relatedLink
     * @return void
     */
    public function created(RelatedLink $relatedLink)
    {
        //
    }

    /**
     * Handle the model "updated" event.
     *
     * @param  \App\Models\RelatedLink $relatedLink
     * @return void
     */
    public function updated(RelatedLink $relatedLink)
    {
        //
    }

    /**
     * Handle the model "deleted" event.
     *
     * @param  \App\Models\RelatedLink $relatedLink
     * @return void
     */
    public function deleted(RelatedLink $relatedLink)
    {
        //
    }

    /**
     * Handle the model "restored" event.
     *
     * @param  \App\Models\RelatedLink $relatedLink
     * @return void
     */
    public function restored(RelatedLink $relatedLink)
    {
        //
    }

    /**
     * Handle the model "force deleted" event.
     *
     * @param  \App\Models\RelatedLink $relatedLink
     * @return void
     */
    public function forceDeleted(RelatedLink $relatedLink)
    {
        //
    }
}
