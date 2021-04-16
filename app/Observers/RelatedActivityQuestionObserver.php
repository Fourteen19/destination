<?php

namespace App\Observers;

use App\Models\RelatedActivityQuestion;
use Illuminate\Support\Str;

class RelatedActivityQuestionObserver
{

    /**
     * Handle the model "creating" event.
     *
     * @param  \App\Models\RelatedActivityQuestion $relatedActivityQuestion
     * @return void
     */
    public function creating(RelatedActivityQuestion $relatedActivityQuestion)
    {
        $relatedActivityQuestion->uuid = Str::uuid();
    }



    /**
     * Handle the model "created" event.
     *
     * @param  \App\Models\RelatedActivityQuestion $relatedActivityQuestion
     * @return void
     */
    public function created(RelatedActivityQuestion $relatedActivityQuestion)
    {
        //
    }

    /**
     * Handle the model "updated" event.
     *
     * @param  \App\Models\RelatedActivityQuestion $relatedActivityQuestion
     * @return void
     */
    public function updated(RelatedActivityQuestion $relatedActivityQuestion)
    {
        //
    }

    /**
     * Handle the model "deleted" event.
     *
     * @param  \App\Models\RelatedActivityQuestion $relatedActivityQuestion
     * @return void
     */
    public function deleted(RelatedActivityQuestion $relatedActivityQuestion)
    {
        //
    }

    /**
     * Handle the model "restored" event.
     *
     * @param  \App\Models\RelatedActivityQuestion $relatedActivityQuestion
     * @return void
     */
    public function restored(RelatedActivityQuestion $relatedActivityQuestion)
    {
        //
    }

    /**
     * Handle the model "force deleted" event.
     *
     * @param  \App\Models\RelatedActivityQuestion $relatedActivityQuestion
     * @return void
     */
    public function forceDeleted(RelatedActivityQuestion $relatedActivityQuestion)
    {
        //
    }
}
