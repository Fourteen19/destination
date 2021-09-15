<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Artesaos\SEOTools\Facades\SEOMeta;
use App\Services\Frontend\CvBuilderService;

class CvBuilderController extends Controller
{

    protected $cvBuilderService;

    /**
      * Create a new controller instance.
      *
      * @return void
      */
    public function __construct(CvBuilderService $cvBuilderService) {

        $this->cvBuilderService = $cvBuilderService;

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

        $cvBuilderButtonLabel = $this->cvBuilderService->getCvBuilderButtonLabel();

        return view('frontend.pages.cv-builder.intro', compact('staticContent', 'cvBuilderButtonLabel'));

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
