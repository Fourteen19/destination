<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\Vacancy;
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\SystemTag;
use App\Models\VacancyLive;
use App\Models\VacancyRole;
use Illuminate\Http\Request;
use App\Models\VacancyRegion;
use App\Http\Controllers\Controller;
use App\Services\Admin\VacancyService;
use Illuminate\Support\Facades\Session;
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


        //search engine
        $areaList = VacancyRegion::where('display', 'Y')->where('client_id', Session::get('fe_client')->id)->orderby('name', 'ASC')->pluck('name', 'uuid');

        $categoryList = SystemTag::withType('sector')
                                        ->where('client_id', NULL)
                                        ->orderBy('name', 'ASC')
                                        ->pluck('name', 'uuid');


        //$jobRoles = VacancyRole::where('display', 'Y')->orderby('name', 'ASC')->get();


        //featured
        $featuredVacancies = $this->vacancyService->getFeaturedVacancies();

        //get vacancies
        $moreVacancies = $this->vacancyService->getMoreVacancies(0, config('global.vacancies.opportunities_vacancies.load_more_number'), $featuredVacancies->pluck('id')->toArray() );

        return view('frontend.pages.vacancies.index', ['areaList' => $areaList,
                                                       'categoryList' => $categoryList,
                                                       //'jobRoles' => $jobRoles,
                                                       'featuredVacancies' => $featuredVacancies,
                                                       'moreVacancies' => $moreVacancies,
                                                    ]);

    }


    /**
     * Show the vacancy.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show($clientSubdomain, Request $request, VacancyLive $vacancy)
    {

        if ($request->has('export')) {
            if ($request->get('export') == 'pdf') {

                //$image = base64_encode(file_get_contents(public_path('/images/vacancies-bg.jpg')));

                $pdf = PDF::setOptions(['show_warnings' => true, 'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => false])
                ->loadView('frontend.pages.vacancies.pdf.show', compact('vacancy'));
                //setOptions(['show_warnings' => false, 'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->
                //$pdf->output();
               return $pdf->download($vacancy->slug.'.pdf');
                //return $pdf->stream();
            }
        }


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



    /**
     * search for jobs
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function search ()
    {

        return view('frontend.pages.vacancies.search');

    }



}
