<?php

namespace App\Observers;

use App\Models\Event;
use Illuminate\Support\Str;

class EventObserver
{

    /**
     * Handle the institution "creating" event.
     *
     * @param  \App\Models\Event $event
     * @return void
     */
    public function creating(Event $event)
    {
        $event->uuid = Str::uuid();
    }



    /**
     * Handle the institution "created" event.
     *
     * @param  \App\Models\Event $event
     * @return void
     */
    public function created(Event $event)
    {
        //
    }

    /**
     * Handle the institution "updated" event.
     *
     * @param  \App\Models\Event $event
     * @return void
     */
    public function updated(Event $event)
    {
        //
    }

    /**
     * Handle the institution "deleted" event.
     *
     * @param  \App\Models\Event $event
     * @return void
     */
    public function deleted(Event $event)
    {
        //
    }

    /**
     * Handle the institution "restored" event.
     *
     * @param  \App\Models\Event $event
     * @return void
     */
    public function restored(Event $event)
    {
        //
    }

    /**
     * Handle the institution "force deleted" event.
     *
     * @param  \App\Models\Event $event
     * @return void
     */
    public function forceDeleted(Event $event)
    {
        //
    }
}
