<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\SystemTag;
use App\Models\VacancyLive;
use Illuminate\Http\Request;
use App\Models\VacancyRegion;
use Barryvdh\DomPDF\Facade as PDF;
use App\Events\ClientVacancyHistory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Artesaos\SEOTools\Facades\SEOMeta;
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
        $areaList = VacancyRegion::where('display', 'Y')->where('client_id', Session::get('fe_client')['id'])->orderby('name', 'ASC')->pluck('name', 'uuid');

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

        SEOMeta::setTitle($vacancy->title);

        if ($request->has('export')) {
            if ($request->get('export') == 'pdf') {

                $pdf = PDF::setOptions(['show_warnings' => true, 'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => false, 'chroot' => [ realpath(base_path()).'/public/images', realpath(base_path()).'/public/media'] ])
                ->loadView('frontend.pages.vacancies.pdf.show', compact('vacancy'));

               return $pdf->download($vacancy->slug.'.pdf');

            }
        }


        $relatedVacancies = $this->vacancyService->getRelatedVacancy($vacancy->id);

        $this->vacancyService->userAccessVacancies($vacancy->id);


        $logAccess = False;
        if (Auth::guard('web')->check())
        {

            if (Auth::guard('web')->user()->type == 'user')
            {

                $clientId = Auth::guard('web')->user()->client_id;
                $logAccess = True;

            }

        } else {

            $logAccess = True;
            $clientId = Session::get('fe_client')['id'];

        }


        if ($logAccess)
        {
            //fires an event to log the access
            event(new ClientVacancyHistory( $vacancy, $clientId ));
        }



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

            //featured
            $featuredVacancies = $this->vacancyService->getFeaturedVacancies();

            $data = $this->vacancyService->getMoreVacancies($request->offset, config('global.vacancies.opportunities_vacancies.load_more_number'), $featuredVacancies->pluck('id')->toArray() );

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
