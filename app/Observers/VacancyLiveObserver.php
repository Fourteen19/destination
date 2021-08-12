<?php

namespace App\Observers;

use App\Models\VacancyLive;
use Illuminate\Support\Str;

class VacancyLiveObserver
{

    /**
     * Handle the vacancy "creating" event.
     *
     * @param  \App\Models\VacancyLive $vacancyLive
     * @return void
     */
    public function creating(VacancyLive $vacancyLive)
    {
        $vacancyLive->uuid = Str::uuid();
    }



    /**
     * Handle the vacancy "created" event.
     *
     * @param  \App\Models\VacancyLive $vacancyLive
     * @return void
     */
    public function created(VacancyLive $vacancyLive)
    {
        //
    }

    /**
     * Handle the vacancy "updated" event.
     *
     * @param  \App\Models\VacancyLive $vacancyLive
     * @return void
     */
    public function updated(VacancyLive $vacancyLive)
    {
        //
    }

    /**
     * Handle the vacancy "deleted" event.
     *
     * @param  \App\Models\VacancyLive $vacancyLive
     * @return void
     */
    public function deleted(VacancyLive $vacancyLive)
    {
        //
    }

    /**
     * Handle the vacancy "restored" event.
     *
     * @param  \App\Models\VacancyLive $vacancyLive
     * @return void
     */
    public function restored(VacancyLive $vacancyLive)
    {
        //
    }

    /**
     * Handle the vacancy "force deleted" event.
     *
     * @param  \App\Models\VacancyLive $vacancyLive
     * @return void
     */
    public function forceDeleted(VacancyLive $vacancyLive)
    {
        //
    }
}
