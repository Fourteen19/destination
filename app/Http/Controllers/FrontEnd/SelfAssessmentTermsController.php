<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SystemTag;
use App\Http\Requests\Frontend\SelfAssessmentTerms;

class SelfAssessmentTermsController extends Controller
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

        $terms = SystemTag::where('type', 'term')->where('live', 'Y')->get();

        //gets the tags allocated to the content
        $userTermTags = auth()->user()->tagsWithType('term'); // returns a collection

        return view('frontend.pages.self-assessment.terms', ['tagsTerms' => $terms, 'userTermTags' => $userTermTags]);

    }


/**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\ContentStoreRequest  $request
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function update(SelfAssessmentTerms $request)
    {

        // Will return only validated data
        $validatedData = $request->validated();


        if (!isset($validatedData['tagsTerms']))
        {
            auth()->user()->syncTagsWithType([], 'term');

        } else {

            //attaches tags to the content
            auth()->user()->syncTagsWithType( $validatedData['tagsTerms'], 'term' );
        }


        $goToRoute = "";
        if ($validatedData['submit'] == 'previous')
        {
            $goToRoute = 'frontend.self-assessment.role-types.edit';

        } else {

            $goToRoute = 'frontend.self-assessment.subjects.edit';

        }

        return redirect()->route($goToRoute)->with('success', 'Terms added to your profile');

    }



}
