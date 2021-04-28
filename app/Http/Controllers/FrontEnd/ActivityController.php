<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\ContentLive;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Services\Frontend\ActivitiesService;
use Illuminate\Database\Eloquent\Relations\MorphMany;


class ActivityController extends Controller
{


    /**
      * Create a new controller instance.
      *
      * @return void
      */
    public function __construct() {


    }



    public function suggestedIndex(ActivitiesService $activitiesService)
    {

        $data = $activitiesService->getAllActivitiesNotCompletedByUser();

        return view('frontend.pages.activities.suggested.index', ['data' => $data]);

    }



    /**
     * allActivitiesCompleted
     * Displays all activities completed by a user
     *
     * @param  mixed $request
     * @return void
     */
    public function completedIndex(ActivitiesService $activitiesService)
    {

        $data = $activitiesService->getAllActivitiesCompletedByUser();

        return view('frontend.pages.activities.completed.index', ['data' => $data]);

    }


    /**
     * show
     *
     * @param  mixed $clientSubdomain
     * @param  mixed $article
     * @param  mixed $relatedArticlesService
     * @param  mixed $youMightLikeArticlesService
     * @return void
     */
    public function show(String $clientSubdomain, ContentLive $activity)
    {

        return view('frontend.pages.activities.show', ['content' => $activity]);

    }

}
