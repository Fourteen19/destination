<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Artesaos\SEOTools\Facades\SEOMeta;
use App\Services\Frontend\DashboardService;
use App\Services\Frontend\UserAccountService;
use App\Services\Frontend\SelfAssessmentService;

class DashboardController extends Controller
{

    protected $dashboardService;

    protected $selfAssessmentService;

    /**
      * Create a new controller instance.
      *
      * @return void
   */
    public function __construct(DashboardService $dashboardService, SelfAssessmentService $selfAssessmentService, UserAccountService $userAccountService) {

        $this->dashboardService = $dashboardService;

        $this->selfAssessmentService = $selfAssessmentService;

        $this->userAccountService = $userAccountService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        SEOMeta::setTitle('Your personalised home page');

        if (!$this->userAccountService->checkIfUserHasAcceptedTerms())
        {
            //redirect to the password reset page
            return redirect()->route('frontend.welcome');
        }

        //only for users, not admins
        if ( (!$this->userAccountService->checkIfUserHasChangedPassword()) && (Auth::guard('web')->user()->type == "user") )
        {
            //redirect to the password reset page
            return redirect()->route('frontend.get-started');
        }

        //Checks if the current assessment has tags for all tags type
        if (!$this->selfAssessmentService->checkIfCurrentAssessmentIsComplete())
        {
            //redirect to the dashboard
            return redirect()->route('frontend.self-assessment.career-readiness.edit');
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
