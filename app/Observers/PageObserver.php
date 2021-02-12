<?php

namespace App\Observers;

use App\Models\Page;
use Illuminate\Support\Str;

class PageObserver
{

    /**
     * Handle the institution "creating" event.
     *
     * @param  \App\Models\Page $page
     * @return void
     */
    public function creating(Page $page)
    {
        $page->uuid = Str::uuid();
    }



    /**
     * Handle the institution "created" event.
     *
     * @param  \App\Models\Page $page
     * @return void
     */
    public function created(Page $page)
    {
        //
    }

    /**
     * Handle the institution "updated" event.
     *
     * @param  \App\Models\Page $page
     * @return void
     */
    public function updated(Page $page)
    {
        //
    }

    /**
     * Handle the institution "deleted" event.
     *
     * @param  \App\Models\Page $page
     * @return void
     */
    public function deleted(Page $page)
    {
        //
    }

    /**
     * Handle the institution "restored" event.
     *
     * @param  \App\Models\Page $page
     * @return void
     */
    public function restored(Page $page)
    {
        //
    }

    /**
     * Handle the institution "force deleted" event.
     *
     * @param  \App\Models\Page $page
     * @return void
     */
    public function forceDeleted(Page $page)
    {
        //
    }
}
