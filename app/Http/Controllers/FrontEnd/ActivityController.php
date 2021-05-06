<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\ContentLive;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Artesaos\SEOTools\Facades\SEOMeta;
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
        //
    }



    public function suggestedIndex()
    {//ActivitiesService $activitiesService

        //if the user's institution has the "work experience" section enabled
        if (Auth::guard('web')->user()->institution->work_experience == 'Y')
        {

            SEOMeta::setTitle("My suggested Activities");

            //$data = $activitiesService->getAllActivitiesNotCompletedByUser();
//, ['data' => $data]
            return view('frontend.pages.activities.suggested.index');

        } else {

            return redirect()->route('frontend.dashboard');

        }

    }



    /**
     * allActivitiesCompleted
     * Displays all activities completed by a user
     *
     * @param  mixed $request
     * @return void
     */
    public function completedIndex()
    {//ActivitiesService $activitiesService

        //if the user's institution has the "work experience" section enabled
        if (Auth::guard('web')->user()->institution->work_experience == 'Y')
        {

            SEOMeta::setTitle("My completed Activities");

            //$data = $activitiesService->getAllActivitiesCompletedByUser();
//, ['data' => $data]
            return view('frontend.pages.activities.completed.index');

        } else {

            return redirect()->route('frontend.dashboard');

        }
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

        //if the user's institution has the "work experience" section enabled
        if (Auth::guard('web')->user()->institution->work_experience == 'Y')
        {

            SEOMeta::setTitle($activity->title);

            return view('frontend.pages.activities.show', ['content' => $activity]);

        } else {

            return redirect()->route('frontend.dashboard');

        }
    }

}
