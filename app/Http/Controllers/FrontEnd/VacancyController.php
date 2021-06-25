<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\Vacancy;
use App\Models\VacancyLive;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\VacancyService;
use App\Services\Frontend\VacanciesService;

class VacancyController extends Controller
{

    protected $vacancyService;

    /**
      * Create a new controller instance.
      *
      * @return void
   */
    public function __construct(VacanciesService $vacancyService) {
        $this->vacancyService = $vacancyService;
    }

    /**
     * Show the application vacancies.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $featuredVacancies = $this->vacancyService->getFeaturedVacancies();

        return view('frontend.pages.vacancies.index', ['featuredVacancies' => $featuredVacancies]);

    }


    /**
     * Show the vacancy.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show($clientSubdomain, VacancyLive $vacancy)
    {

        $relatedVacancies = $this->vacancyService->getRelatedVacancy($vacancy->id);

        return view('frontend.pages.vacancies.show', ['vacancy' => $vacancy,
                                                      'relatedVacancies' => $relatedVacancies,
                                                    ]);

    }
}
