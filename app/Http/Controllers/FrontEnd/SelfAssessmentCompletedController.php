<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Artesaos\SEOTools\Facades\SEOMeta;

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
     * Show the self-assessment completed screen.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        SEOMeta::setTitle("Thanks ". Auth::guard('web')->user()->first_name ." you're all done");

        return view('frontend.pages.self-assessment.completed', [
                                                                    'data' => app('clientContentSettigsSingleton')->getAssessmentCompletedIntro()
                                                                ]);

    }

}
