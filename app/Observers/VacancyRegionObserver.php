<?php

namespace App\Observers;

use App\Models\VacancyRegion;
use Illuminate\Support\Str;

class VacancyRegionObserver
{

    /**
     * $Handle the vacancy role "creating" event.
     *
     * @param  \App\Models\VacancyRegion $vacancyRegion
     * @return void
     */
    public function creating(VacancyRegion $vacancyRegion)
    {
        $vacancyRegion->uuid = Str::uuid();
    }



    /**
     * $Handle the vacancy role "created" event.
     *
     * @param  \App\Models\VacancyRegion $vacancyRegion
     * @return void
     */
    public function created(VacancyRegion $vacancyRegion)
    {
        //
    }

    /**
     * $Handle the vacancy role "updated" event.
     *
     * @param  \App\Models\VacancyRegion $vacancyRegion
     * @return void
     */
    public function updated(VacancyRegion $vacancyRegion)
    {
        //
    }

    /**
     * $Handle the vacancy role "deleted" event.
     *
     * @param  \App\Models\VacancyRegion $vacancyRegion
     * @return void
     */
    public function deleted(VacancyRegion $vacancyRegion)
    {
        //
    }

    /**
     * $Handle the vacancy role "restored" event.
     *
     * @param  \App\Models\VacancyRegion $vacancyRegion
     * @return void
     */
    public function restored(VacancyRegion $vacancyRegion)
    {
        //
    }

    /**
     * $Handle the vacancy role "force deleted" event.
     *
     * @param  \App\Models\VacancyRegion $vacancyRegion
     * @return void
     */
    public function forceDeleted(VacancyRegion $vacancyRegion)
    {
        //
    }
}
