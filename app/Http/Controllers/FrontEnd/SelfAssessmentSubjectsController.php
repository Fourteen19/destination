<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\SystemTag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Frontend\SelfAssessmentService;
use App\Http\Requests\Frontend\SelfAssessmentSubjects;

class SelfAssessmentSubjectsController extends Controller
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
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {

        $subjects = SystemTag::getLiveTags('subject');

        //gets allocated `subject` tags
        $selfAssessmentSubjectTags = $this->selfAssessmentService->getAllocatedSubjectTagsSelfAssessmentRadioScores();

        return view('frontend.pages.self-assessment.subjects', ['tagsSubjects' => $subjects,
                                                                'userSubjectTags' => $selfAssessmentSubjectTags,
                                                                'data' => app('clientContentSettigsSingleton')->getSubjectsIntro()
        ]);

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\SelfAssessmentSubjects  $request
     * @return \Illuminate\Http\Response
     */
    public function update(SelfAssessmentSubjects $request)
    {

        // Will return only validated data
        $validatedData = $request->validated();

        //gets the service to allocate the `subject` tags
        $this->selfAssessmentService->AllocateSubjectTags($validatedData['subjects']);

        $goToRoute = "";
        if ($validatedData['submit'] == 'Previous') {
            $goToRoute = 'frontend.self-assessment.career-readiness.edit';
        } else {
            $goToRoute = 'frontend.self-assessment.routes.edit';
        }

        return redirect()->route($goToRoute);

    }



}
