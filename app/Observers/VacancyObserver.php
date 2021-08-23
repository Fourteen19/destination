<?php

namespace App\Observers;

use App\Models\Vacancy;
use Illuminate\Support\Str;

class VacancyObserver
{

    /**
     * Handle the vacancy "creating" event.
     *
     * @param  \App\Models\Vacancy $vacancy
     * @return void
     */
    public function creating(Vacancy $vacancy)
    {
        $vacancy->uuid = Str::uuid();
    }



    /**
     * Handle the vacancy "created" event.
     *
     * @param  \App\Models\Vacancy $vacancy
     * @return void
     */
    public function created(Vacancy $vacancy)
    {
        //
    }

    /**
     * Handle the vacancy "updated" event.
     *
     * @param  \App\Models\Vacancy $vacancy
     * @return void
     */
    public function updated(Vacancy $vacancy)
    {
        //
    }

    /**
     * Handle the vacancy "deleted" event.
     *
     * @param  \App\Models\Vacancy $vacancy
     * @return void
     */
    public function deleted(Vacancy $vacancy)
    {
        //
    }

    /**
     * Handle the vacancy "restored" event.
     *
     * @param  \App\Models\Vacancy $vacancy
     * @return void
     */
    public function restored(Vacancy $vacancy)
    {
        //
    }

    /**
     * Handle the vacancy "force deleted" event.
     *
     * @param  \App\Models\Vacancy $vacancy
     * @return void
     */
    public function forceDeleted(Vacancy $vacancy)
    {
        //
    }
}
