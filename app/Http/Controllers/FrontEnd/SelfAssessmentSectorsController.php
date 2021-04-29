<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\SystemTag;
use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\SEOMeta;
use App\Services\Frontend\SelfAssessmentService;
use App\Http\Requests\Frontend\SelfAssessmentSectors;

class SelfAssessmentSectorsController extends Controller
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
    public function edit()
    {

        SEOMeta::setTitle("Getting to know you: Sectors");

        $sectors = SystemTag::getLiveTags('sector');

        //gets allocated `sector` tags
        $selfAssessmentSectorTags = $this->selfAssessmentService->getAllocatedSectorTags();

        return view('frontend.pages.self-assessment.sectors', ['sectors' => $sectors,
                                                               'userSectorTags' => $selfAssessmentSectorTags,
                                                               'data' => app('clientContentSettigsSingleton')->getSectorsIntro()
                                                               ]);

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

        //gets the service to allocate the `sector` tags
        $this->selfAssessmentService->AllocateSectorTags($validatedData['sectors']);

        $goToRoute = "";
        if ($validatedData['submit'] == 'Previous') {
            $goToRoute = 'frontend.self-assessment.routes.edit';
        } else {

            $goToRoute = 'frontend.self-assessment.completed';
        }

        return redirect()->route($goToRoute);

    }



}
