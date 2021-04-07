<?php

namespace App\Observers;

use App\Models\RelatedQuestion;
use Illuminate\Support\Str;

class RelatedQuestionObserver
{

    /**
     * Handle the model "creating" event.
     *
     * @param  \App\Models\RelatedQuestion $relatedQuestion
     * @return void
     */
    public function creating(RelatedQuestion $relatedQuestion)
    {
        $relatedQuestion->uuid = Str::uuid();
    }



    /**
     * Handle the model "created" event.
     *
     * @param  \App\Models\RelatedQuestion $relatedQuestion
     * @return void
     */
    public function created(RelatedQuestion $relatedQuestion)
    {
        //
    }

    /**
     * Handle the model "updated" event.
     *
     * @param  \App\Models\RelatedQuestion $relatedQuestion
     * @return void
     */
    public function updated(RelatedQuestion $relatedQuestion)
    {
        //
    }

    /**
     * Handle the model "deleted" event.
     *
     * @param  \App\Models\RelatedQuestion $relatedQuestion
     * @return void
     */
    public function deleted(RelatedQuestion $relatedQuestion)
    {
        //
    }

    /**
     * Handle the model "restored" event.
     *
     * @param  \App\Models\RelatedQuestion $relatedQuestion
     * @return void
     */
    public function restored(RelatedQuestion $relatedQuestion)
    {
        //
    }

    /**
     * Handle the model "force deleted" event.
     *
     * @param  \App\Models\RelatedQuestion $relatedQuestion
     * @return void
     */
    public function forceDeleted(RelatedQuestion $relatedQuestion)
    {
        //
    }
}
