<?php

namespace App\Services\Frontend;

use App\Models\VacancyLive;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;


Class VacanciesService
{

    /**
      * Create a new controller instance.
      *
      * @return void
    */
    public function __construct() {
        //
    }


    public function getLatestVacancies()
    {

        return VacancyLive::orderBy('updated_at', 'ASC')
                    ->limit(2)
                    ->get();


    }

}
