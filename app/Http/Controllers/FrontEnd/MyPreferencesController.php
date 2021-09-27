<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\SystemTag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\SEOMeta;
use App\Services\Frontend\SelfAssessmentService;
use App\Http\Requests\Frontend\SelfAssessmentMyPreferences;

class MyPreferencesController extends Controller
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

        SEOMeta::setTitle("Update my preferencess");

        $subjects = SystemTag::getLiveTags('subject');

        //gets allocated `subject` tags
        $selfAssessmentSubjectTags = $this->selfAssessmentService->getAllocatedSubjectTagsSelfAssessmentRadioScores();

        $sectors = SystemTag::getLiveTags('sector');

        //gets allocated `sector` tags
        $selfAssessmentSectorTags = $this->selfAssessmentService->getAllocatedSectorTags();

        $routes = SystemTag::getLiveTags('route');

        //gets allocated `route` tags
        $selfAssessmentRouteTags = $this->selfAssessmentService->getAllocatedRouteTags();
        //dd($selfAssessmentRouteTags);
        return view('frontend.pages.my-account.update-my-preferences', ['tagsSubjects' => $subjects,
                                                                        'userSubjectTags' => $selfAssessmentSubjectTags,
                                                                        'sectors' => $sectors,
                                                                        'userSectorTags' => $selfAssessmentSectorTags,
                                                                        'routes' => $routes,
                                                                        'userRouteTags' => $selfAssessmentRouteTags,
                                                                        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\SelfAssessmentMyPreferences  $request
     * @return \Illuminate\Http\Response
     */
    public function update(SelfAssessmentMyPreferences $request)
    {

        // Will return only validated data
        $validatedData = $request->validated();

        //gets the service to allocate the `subject` tags
        $this->selfAssessmentService->AllocateSubjectTags($validatedData['subjects']);

        //gets the service to allocate the `route` tags
        $this->selfAssessmentService->AllocateRouteTags($validatedData['routes']);

        //gets the service to allocate the `subject` tags
        $this->selfAssessmentService->AllocateSectorTags($validatedData['sectors']);

        //check if the assessment is complete
        $this->selfAssessmentService->checkIfCurrentAssessmentIsComplete();

        //clears dashboard slots to display the new data
        $this->selfAssessmentService->clearAllSlotfromDashboard();

        //clears "something different" slots to display the new data
        $this->selfAssessmentService->clearAllSlotfromSomethingDifferentPanel();

        return redirect()->route('frontend.my-account.update-my-preferences.edit')->with('success', 'Preferences updated');

    }

}
