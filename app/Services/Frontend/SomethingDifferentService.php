<?php

namespace App\Services\Frontend;

use App\Models\SystemTag;
use App\Models\ContentLive;
use Illuminate\Support\Facades\Auth;
use App\Services\Frontend\ArticlesService;

Class SomethingDifferentService
{

    protected $articlesService;

    protected $selfAssessmentService;

    public function __construct(ArticlesService $articlesService, selfAssessmentService $selfAssessmentService)
    {
        $this->articlesService = $articlesService;

        $this->selfAssessmentService = $selfAssessmentService;

    }



    /**
     * getSomethingDifferentArticlesSummary
     *
     * @return void
     */
    public function getSomethingDifferentArticlesSummary()
    {

        //get the route tags related to the user assessment
        $assessmentRoutesTags = $this->selfAssessmentService->getAllocatedRouteTags()->toArray();

        $routesTags = [];
        foreach($assessmentRoutesTags as $key => $assessmentRoutesTag){
            $routesTags[] = $assessmentRoutesTag['id'];
        }

        //gets the routes not allocated to the user assessement
        $routesTags = SystemTag::getLiveTagsNotIn('route', $routesTags)->toArray();





        //get the sector tags not related to the user assessment
        $assessmentSectorsTags = $this->selfAssessmentService->getAllocatedSectorTags()->toArray();

        $sectorsTags = [];
        foreach($assessmentSectorsTags as $key => $assessmentSectorsTag){
            $sectorsTags[] = $assessmentSectorsTag['id'];
        }

        //gets the routes not allocated to the user assessement
        $sectorsTags = SystemTag::getLiveTagsNotIn('sector', $sectorsTags)->toArray();





        //get the subject tags not related to the user assessment
        $assessmentSubjectsTags = $this->selfAssessmentService->getAllocatedSubjectTags()->toArray();
//dd($assessmentSubjectsTags);
        $subjectsTags = [];
        foreach($assessmentSubjectsTags as $key => $assessmentSubjectsTag){
            $subjectsTags[] = $assessmentSubjectsTag['id'];
        }

        //gets the routes not allocated to the user assessement
        $subjectsTags = SystemTag::getLiveTagsNotIn('subject', $subjectsTags)->toArray();
//dd($subjectsTags);




        //gets all articles related to a user
        $userArticles = [];


        $aricles = ContentLive::withAnyTags([ Auth::guard('web')->user()->school_year ], 'year')
                                        ->join('content_live_user', 'content_live_user.content_live_id', '=', 'contents_live.id')
                                        ->where('content_live_user.user_id', '=', Auth::guard('web')->user()->id)
                                        ->whereNotIn('content_live.id', $userArticles)
                                        ->orderBy('content_live_user.updated_at', 'DESC')
                                        ->select('id', 'summary_heading', 'summary_text', 'slug')
                                        ->limit(3)
                                        ->get();



        return   $aricles;
/*
        service->savesToDashboard(
            [
                'something_diffeernt_slot_1' =>
                'something_diffeernt_slot_2' =>
                'something_diffeernt_slot_3' =>


            ]

        );
*/
    }

}
