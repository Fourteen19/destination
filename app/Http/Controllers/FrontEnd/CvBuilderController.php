<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Support\Facades\Session;

class CvBuilderController extends Controller
{


    /**
      * Create a new controller instance.
      *
      * @return void
      */
    public function __construct() {

    }



    /**
     * Show the CV Builder Intro screen.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $staticContent = app('clientContentSettigsSingleton')->getCvBuilderIntroPageText();

        SEOMeta::setTitle("CV Builder Introduction");

        return view('frontend.pages.cv-builder.intro', compact('staticContent'));

    }



    /**
     * Edit the CV.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit()
    {

        SEOMeta::setTitle("CV Builder");

        $staticContent = app('clientContentSettigsSingleton')->getCvBuilderInstructionPageText();

        return view('frontend.pages.cv-builder.edit', compact('staticContent'));

    }


}
