<?php

namespace App\Observers;

use App\Models\Content;
use Illuminate\Support\Str;

class ContentObserver
{

    /**
     * Handle the institution "creating" event.
     *
     * @param  \App\Models\Content $content
     * @return void
     */
    public function creating(Content $content)
    {
        $content->uuid = Str::uuid();
    }



    /**
     * Handle the institution "created" event.
     *
     * @param  \App\Models\Institution  $institution
     * @return void
     */
    public function created(Content $content)
    {
        //
    }

    /**
     * Handle the institution "updated" event.
     *
     * @param  \App\Models\Content $content
     * @return void
     */
    public function updated(Content $content)
    {
        //
    }

    /**
     * Handle the institution "deleted" event.
     *
     * @param  \App\Models\Content $content
     * @return void
     */
    public function deleted(Content $content)
    {
        //
    }

    /**
     * Handle the institution "restored" event.
     *
     * @param  \App\Models\Content $content
     * @return void
     */
    public function restored(Content $content)
    {
        //
    }

    /**
     * Handle the institution "force deleted" event.
     *
     * @param  \App\Models\Content $content
     * @return void
     */
    public function forceDeleted(Content $content)
    {
        //
    }
}
