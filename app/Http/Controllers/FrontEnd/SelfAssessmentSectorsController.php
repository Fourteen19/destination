<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\SystemTag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Frontend\selfAssessmentService;
use App\Http\Requests\Frontend\SelfAssessmentSectors;

class SelfAssessmentSectorsController extends Controller
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

        $sectors = SystemTag::getLiveTags('sector');

        //gets allocated `sector` tags
        $selfAssessmentSectorTags = $this->selfAssessmentService->getAllocatedSectorTags();

        return view('frontend.pages.self-assessment.sectors', ['sectors' => $sectors, 'userSectorTags' => $selfAssessmentSectorTags]);

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

        return redirect()->route($goToRoute)->with('success', 'Sectors added to your profile');

    }



}
