<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SystemTag;
use App\Http\Requests\Frontend\SelfAssessmentSubjects;

class SelfAssessmentCompletedController extends Controller
{

    /**
      * Create a new controller instance.
      *
      * @return void
    */
    public function __construct() {

    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        return view('frontend.pages.self-assessment.completed',
        [
            'data' => app('clientContentSettigsSingleton')->getAssessmentCompletedIntro()
        ]);

    }

}
