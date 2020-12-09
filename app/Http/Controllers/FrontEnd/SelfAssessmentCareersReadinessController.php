<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SystemTag;
use App\Http\Requests\Frontend\SelfAssessmentTerms;

class SelfAssessmentCareersReadinessController extends Controller
{
    /**
      * Create a new controller instance.
      *
      * @return void
    */
    public function __construct() {

    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {

        return view('frontend.pages.self-assessment.careers-readiness');

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\  $request
     * @return \Illuminate\Http\Response
     */
    public function update()
    {



    }



}
