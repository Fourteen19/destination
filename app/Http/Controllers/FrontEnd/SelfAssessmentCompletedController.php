<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Artesaos\SEOTools\Facades\SEOMeta;
use App\Services\Frontend\SelfAssessmentService;

class SelfAssessmentCompletedController extends Controller
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
     * Show the self-assessment completed screen.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        SEOMeta::setTitle("Thanks ". Auth::guard('web')->user()->first_name ." you're all done");

        $this->selfAssessmentService->checkIfCurrentAssessmentIsComplete();

        return view('frontend.pages.self-assessment.completed', [
                                                                    'data' => app('clientContentSettingsSingleton')->getAssessmentCompletedIntro()
                                                                ]);

    }

}
