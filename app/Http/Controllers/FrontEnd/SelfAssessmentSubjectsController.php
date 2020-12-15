<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\SystemTag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Frontend\selfAssessmentService;
use App\Http\Requests\Frontend\SelfAssessmentSubjects;

class SelfAssessmentSubjectsController extends Controller
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

        $subjects = SystemTag::getLiveTags('subject'); //where('type', 'subject')->where('live', 'Y')->get();

        //gets the tags allocated to the content
        //$userSubjectTags = auth()->user()->tagsWithType('subject'); // returns a collection
/*
        //gets the current self assessment
        $selfAssessment = $this->selfAssessmentService->getSelfAssessment();

        //gets the subjects tags for the assessment
        $selfAssessmentSubjectTags = $selfAssessment->tagsWithType('subject'); // returns a collection
*/
        //gets allocated `subject` tags
        $selfAssessmentSubjectTags = $this->selfAssessmentService->getAllocatedSubjectTags();

        return view('frontend.pages.self-assessment.subjects', ['tagsSubjects' => $subjects, 'selfAssessmentTags' => $selfAssessmentSubjectTags]);

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

        return redirect()->route($goToRoute)->with('success', 'Subjects added to your profile');

    }



}
