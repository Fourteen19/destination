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

        //$opportunitiesVacancies = $this->vacancyService->getVacancies(3, []);

        //get vacancies
        $moreVacancies = $this->vacancyService->getMoreVacancies(0, config('global.vacancies.opportunities_vacancies.load_more_number') );

        return view('frontend.pages.vacancies.index', ['featuredVacancies' => $featuredVacancies,
                                                        'moreVacancies' => $moreVacancies,
                                                    ]);

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


    /**
     * loadMoreVacancies
     * call from JS ajax script to load more vacancies
     *
     * @param  mixed $request
     * @return void
     */
    public function loadMoreVacancies(Request $request)
    {

        if ($request->ajax())
        {

            $data = $this->vacancyService->getMoreVacancies($request->offset, config('global.vacancies.opportunities_vacancies.load_more_number') );

            if(!$data->isEmpty())
            {
                $html = view('frontend.pages.includes.vacancies.opportunities-vacancies', ['moreVacancies' => $data  ])->render();

                return response()->json(['view'=>$html, 'nb_vacancies' => count($data)]);

            } else {

                return ['nb_vacancies' => 0];

            }

        } else {
            abort(404);
        }

    }

}
