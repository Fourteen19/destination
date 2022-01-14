<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\SEOMeta;
use App\Services\Frontend\SelfAssessmentService;
use App\Http\Requests\Frontend\SelfAssessmentCareerReadiness;

class SelfAssessmentCareerReadinessController extends Controller
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
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {

        SEOMeta::setTitle("Thinking about your career");

        //gets the current self assessment
        $selfAssessment = $this->selfAssessmentService->getSelfAssessment();

        return view('frontend.pages.self-assessment.career-readiness',
                                        [
                                            'selfAssessment' => $selfAssessment,
                                            'data' => app('clientContentSettingsSingleton')->getCareersIntro()
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

        } catch (\Exception $e) {

            return false;

        }

        return redirect()->route('frontend.self-assessment.subjects.edit');

    }



}
