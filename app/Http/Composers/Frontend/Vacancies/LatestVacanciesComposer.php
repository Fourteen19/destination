<?php

namespace App\Http\Composers\Frontend\Vacancies;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Services\Frontend\VacanciesService;

class LatestVacanciesComposer
{

    protected $vacanciesService;

    public function __construct(VacanciesService $vacanciesService)
    {
        $this->vacanciesService = $vacanciesService;
    }


    public function compose(View $view)
    {
       // dd( $this->vacanciesService->getLatestVacancies() );
        //if the user is logged in
        if (Auth::guard('web')->check())
        {

            $view->with('vacancies', $this->vacanciesService->getLatestVacancies() );

        }

    }


}
