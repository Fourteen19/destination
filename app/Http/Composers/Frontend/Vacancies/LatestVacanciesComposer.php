<?php

namespace App\Http\Composers\Frontend\Vacancies;

use Illuminate\Contracts\View\View;
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
        $view->with('vacancies', $this->vacanciesService->getLatestVacancies() );
    }

}
