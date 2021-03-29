<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\SystemTag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Frontend\SelfAssessmentService;
use App\Http\Requests\Frontend\SelfAssessmentRoutes;

class SelfAssessmentRoutesController extends Controller
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

        //$routes = SystemTag::getLive        //$routes = SystemTag::where('type', 'route')->where('live', 'Y')->get();

        $routes = SystemTag::getLiveTags('route');

        //gets the tags allocated to the content
        //$userRouteTags = auth()->user()->tagsWithType('route'); // returns a collection

        //gets allocated `route` tags
        $selfAssessmentRouteTags = $this->selfAssessmentService->getAllocatedRouteTags();

        return view('frontend.pages.self-assessment.routes', ['routes' => $routes,
                                                              'userRouteTags' => $selfAssessmentRouteTags,
                                                              'data' => app('clientContentSettigsSingleton')->getRoutesIntro()
                                                              ]);

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

        $this->selfAssessmentService->AllocateRouteTags($validatedData['routes']);

        $goToRoute = "";
        if ($validatedData['submit'] == 'Previous') {
            $goToRoute = 'frontend.self-assessment.subjects.edit';
        } else {

            $goToRoute = 'frontend.self-assessment.sectors.edit';
        }

        return redirect()->route($goToRoute);

    }



}
