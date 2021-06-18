<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Services\Frontend\DashboardService;
use App\Services\Frontend\SelfAssessmentService;
use Artesaos\SEOTools\Facades\SEOMeta;
class DashboardController extends Controller
{

    protected $dashboardService;

    protected $selfAssessmentService;

    /**
      * Create a new controller instance.
      *
      * @return void
   */
    public function __construct(DashboardService $dashboardService, SelfAssessmentService $selfAssessmentService) {

        $this->dashboardService = $dashboardService;

        $this->selfAssessmentService = $selfAssessmentService;




    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        SEOMeta::setTitle('Your personalised home page');

        //dd( Session::all() );
        //Checks if the current assessment has tags for all tags type
        if (!$this->selfAssessmentService->checkIfCurrentAssessmentIsComplete())
        {
            //redirect to the dashboard
            return redirect()->route('frontend.welcome');
        }

        $articles = $this->dashboardService->getArticlesPanel();

        $slot1 = $articles->shift();
        $slot2 = $articles->shift();
        $slot3 = $articles->shift();
        $slot4 = $articles->shift();
        $slot5 = $articles->shift();
        $slot6 = $articles->shift();

        $screenData = app('clientContentSettigsSingleton')->getWorkExperienceDashboardIntro();

        return view('frontend.pages.dashboard', ['slot1' => $slot1,
                                                'slot2' => $slot2,
                                                'slot3' => $slot3,
                                                'slot4' => $slot4,
                                                'slot5' => $slot5,
                                                'slot6' => $slot6,
                                                'screenData' => $screenData,
                                            ]);

    }
}
