<?php

namespace App\Observers;

use App\Models\VacancyRole;
use Illuminate\Support\Str;

class VacancyRoleObserver
{

    /**
     * $Handle the vacancy role "creating" event.
     *
     * @param  \App\Models\VacancyRole $vacancyRole
     * @return void
     */
    public function creating(VacancyRole $vacancyRole)
    {
        $vacancyRole->uuid = Str::uuid();
    }



    /**
     * $Handle the vacancy role "created" event.
     *
     * @param  \App\Models\VacancyRole $vacancyRole
     * @return void
     */
    public function created(VacancyRole $vacancyRole)
    {
        //
    }

    /**
     * $Handle the vacancy role "updated" event.
     *
     * @param  \App\Models\VacancyRole $vacancyRole
     * @return void
     */
    public function updated(VacancyRole $vacancyRole)
    {
        //
    }

    /**
     * $Handle the vacancy role "deleted" event.
     *
     * @param  \App\Models\VacancyRole $vacancyRole
     * @return void
     */
    public function deleted(VacancyRole $vacancyRole)
    {
        //
    }

    /**
     * $Handle the vacancy role "restored" event.
     *
     * @param  \App\Models\VacancyRole $vacancyRole
     * @return void
     */
    public function restored(VacancyRole $vacancyRole)
    {
        //
    }

    /**
     * $Handle the vacancy role "force deleted" event.
     *
     * @param  \App\Models\VacancyRole $vacancyRole
     * @return void
     */
    public function forceDeleted(VacancyRole $vacancyRole)
    {
        //
    }
}
