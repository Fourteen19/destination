<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\SystemTag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Frontend\selfAssessmentService;
use App\Http\Requests\Frontend\SelfAssessmentRoutes;

class SelfAssessmentRoutesController extends Controller
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

        //$routes = SystemTag::where('type', 'route')->where('live', 'Y')->get();

        $routes = SystemTag::getLiveTags('route');

        //gets the tags allocated to the content
        //$userRouteTags = auth()->user()->tagsWithType('route'); // returns a collection

        //gets allocated `subject` tags
        $selfAssessmentRouteTags = $this->selfAssessmentService->getAllocatedRouteTags();

        return view('frontend.pages.self-assessment.routes', ['routes' => $routes, 'userRouteTags' => $selfAssessmentRouteTags]);

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
/*
        //if no tags are submitted
        if (!isset($validatedData['tagsRoutes']))
        {
            //remove all 'subject' tags
            auth()->user()->syncTagsWithType([], 'route');

        } else {

            //attaches 'subject' tags to the content
            auth()->user()->syncTagsWithType( $validatedData['tagsRoutes'], 'route' );
        }
*/


        //gets the service to allocate the `subject` tags
        $this->selfAssessmentService->AllocateRouteTags($validatedData['routes']);

        $goToRoute = "";
        if ($validatedData['submit'] == 'Previous') {
            $goToRoute = 'frontend.self-assessment.subjects.edit';
        } else {

            $goToRoute = 'frontend.self-assessment.sectors.edit';
        }

        return redirect()->route($goToRoute)->with('success', 'Routes added to your profile');

    }



}
