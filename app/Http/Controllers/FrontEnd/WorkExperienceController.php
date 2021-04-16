<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;

class WorkExperienceController extends Controller
{


    /**
      * Create a new controller instance.
      *
      * @return void
   */
    public function __construct() {
        //
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show()
    {

        return view('frontend.pages.work-experience.show');

    }
}
