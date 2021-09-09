<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Artesaos\SEOTools\Facades\SEOMeta;
use App\Services\Frontend\SelfAssessmentService;

class WelcomeController extends Controller
{


    protected $selfAssessmentService;

    /**
      * Create a new controller instance.
      *
      * @return void
    */
    public function __construct(SelfAssessmentService $selfAssessmentService) {

        $this->selfAssessmentService = $selfAssessmentService;

    }


    /**
     * Show the application welcome screen.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        SEOMeta::setTitle("Welcome ". Auth::guard('web')->user()->first_name);

        //Checks if the current assessment has tags for all tags type
        if ($this->selfAssessmentService->checkIfCurrentAssessmentIsComplete())
        {
            //redirect to the dashboard
            //return redirect()->route('frontend.dashboard');

        }

        return view('frontend.pages.welcome', ['data' => app('clientContentSettigsSingleton')->getWelcomeIntro()]);

    }
}
