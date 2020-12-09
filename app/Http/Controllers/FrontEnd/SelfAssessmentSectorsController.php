<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\SystemTag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\SelfAssessmentSectors;

class SelfAssessmentSectorsController extends Controller
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

        $sectors = SystemTag::where('type', 'sector')->where('live', 'Y')->get();

        //gets the tags allocated to the content
        $userSectorTags = auth()->user()->tagsWithType('sector'); // returns a collection

        return view('frontend.pages.self-assessment.sectors', ['tagsSectors' => $sectors, 'userSectorTags' => $userSectorTags]);

    }


/**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\SelfAssessmentSectors  $request
     * @return \Illuminate\Http\Response
     */
    public function update(SelfAssessmentSectors $request)
    {

        // Will return only validated data
        $validatedData = $request->validated();

        //if no tags are submitted
        if (!isset($validatedData['tagsSectors']))
        {
            //remove all 'sector' tags
            auth()->user()->syncTagsWithType([], 'sector');

        } else {

            //attaches 'sector' tags to the content
            auth()->user()->syncTagsWithType( $validatedData['tagsSectors'], 'sector' );
        }


        $goToRoute = "";
        if ($validatedData['submit'] == 'previous')
        {
            $goToRoute = 'frontend.self-assessment.routes.edit';

        } else {

            $goToRoute = 'frontend.self-assessment.completed';

        }

        return redirect()->route($goToRoute)->with('success', 'Sectors added to your profile');

    }



}
