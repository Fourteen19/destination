<?php

namespace App\Observers;

use App\Models\Employer;
use Illuminate\Support\Str;

class EmployerObserver
{

    /**
     * Handle the employer "creating" event.
     *
     * @param  \App\Models\Employer $employer
     * @return void
     */
    public function creating(Employer $employer)
    {
        $employer->uuid = Str::uuid();
    }



    /**
     * Handle the employer "created" event.
     *
     * @param  \App\Models\Employer  $employer
     * @return void
     */
    public function created(Employer $employer)
    {
        //
    }

    /**
     * Handle the employer "updated" event.
     *
     * @param  \App\Models\Employer $employer
     * @return void
     */
    public function updated(Employer $employer)
    {
        //
    }

    /**
     * Handle the employer "deleted" event.
     *
     * @param  \App\Models\Employer $employer
     * @return void
     */
    public function deleted(Employer $employer)
    {
        //
    }

    /**
     * Handle the employer "restored" event.
     *
     * @param  \App\Models\Employer $employer
     * @return void
     */
    public function restored(Employer $employer)
    {
        //
    }

    /**
     * Handle the employer "force deleted" event.
     *
     * @param  \App\Models\Employer $employer
     * @return void
     */
    public function forceDeleted(Employer $employer)
    {
        //
    }
}
