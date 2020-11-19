<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SystemTag;
use App\Http\Requests\Frontend\SelfAssessmentSubjects;

class SelfAssessmentSubjectsController extends Controller
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

        $subjects = SystemTag::where('type', 'subject')->where('live', 'Y')->get();

        //gets the tags allocated to the content
        $userSubjectTags = auth()->user()->tagsWithType('subject'); // returns a collection

        return view('frontend.pages.self-assessment.subjects', ['tagsSubjects' => $subjects, 'userSubjectTags' => $userSubjectTags]);

    }


/**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\ContentStoreRequest  $request
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function update(SelfAssessmentSubjects $request)
    {

        // Will return only validated data
        $validatedData = $request->validated();

        //if no tags are submitted
        if (!isset($validatedData['tagsSubjects']))
        {
            //remove all 'subject' tags
            auth()->user()->syncTagsWithType([], 'subject');

        } else {

            //attaches 'subject' tags to the content
            auth()->user()->syncTagsWithType( $validatedData['tagsSubjects'], 'subject' );
        }


        $goToRoute = "";
        if ($validatedData['submit'] == 'previous')
        {
            $goToRoute = 'frontend.self-assessment.terms.edit';

        } else {

            $goToRoute = 'frontend.dashboard';

        }

        return redirect()->route($goToRoute)->with('success', 'Subjects added to your profile');

    }



}
