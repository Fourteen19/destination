<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\Frontend\selfAssessmentService;
use App\Http\Requests\Frontend\SelfAssessmentCareerReadiness;

class SelfAssessmentCareerReadinessController extends Controller
{

    protected $selfAssessmentService;

    /**
      * Create a new controller instance.
      *
      * @return void
    */
    public function __construct(selfAssessmentService $selfAssessmentService) {

        $this->selfAssessmentService = $selfAssessmentService;

    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {

        //gets the current self assessment
        $selfAssessment = $this->selfAssessmentService->getSelfAssessment();

        return view('frontend.pages.self-assessment.career-readiness',
                                        [
                                            'selfAssessment' => $selfAssessment,
                                            'data' => app('clientContentSettigsSingleton')->getCareersIntro()
                                        ]);

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\SelfAssessmentCareerReadiness  $request
     * @return \Illuminate\Http\Response
     */
    public function update(SelfAssessmentCareerReadiness $request)
    {

        // Will return only validated data
        $validatedData = $request->validated();

        try {

            $this->selfAssessmentService->compileAndSaveCareerReadinessScores($validatedData);

        } catch (exception $e) {

            return false;

        }

        return redirect()->route('frontend.self-assessment.subjects.edit')->with('success', 'Your career settings have been added to your profile');

    }



}
