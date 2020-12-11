<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SystemTag;
use App\Http\Requests\Frontend\SelfAssessmentRoutes;

class myArticlesController extends Controller
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

        return view('frontend.pages.my-account.my-articles');

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\SelfAssessmentRoutes  $request
     * @return \Illuminate\Http\Response
     */
    public function update(SelfAssessmentRoutes $request)
    {

        // Will return only validated data
        $validatedData = $request->validated();

        //if no tags are submitted
        if (!isset($validatedData['tagsRoutes']))
        {
            //remove all 'subject' tags
            auth()->user()->syncTagsWithType([], 'route');

        } else {

            //attaches 'subject' tags to the content
            auth()->user()->syncTagsWithType( $validatedData['tagsRoutes'], 'route' );
        }


        $goToRoute = "";
        if ($validatedData['submit'] == 'previous')
        {
            $goToRoute = 'frontend.self-assessment.subjects.edit';

        } else {

            $goToRoute = 'frontend.self-assessment.sectors.edit';

        }

        return redirect()->route($goToRoute)->with('success', 'Routes added to your profile');

    }



}
