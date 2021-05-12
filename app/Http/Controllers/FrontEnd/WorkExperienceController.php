<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\ContentLive;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Artesaos\SEOTools\Facades\SEOMeta;
use App\Services\Frontend\EmployersService;
use App\Services\Frontend\ActivitiesService;
use App\Services\Frontend\ClientContentSettigsService;

class WorkExperienceController extends Controller
{


    /**
      * Create a new controller instance.
      *
      * @return void
   */
    public function __construct() {
        //
    }

    /**
     * Show the work experience dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(ActivitiesService $activitiesService, ClientContentSettigsService $clientContentSettigsService)
    {

        //if the user's institution has the "work experience" section enabled
        if (Auth::guard('web')->user()->canAccessWorkExperience())
        {

            SEOMeta::setTitle("Welcome to the world of work ".Auth::guard('web')->user()->first_name);

            //counts the number of activities completed
            $nbCompletedActivities = $activitiesService->getNbCompletedActivitiesforUser();

            //counts the number of activities in the system
            $nbActivitiesInSystem = $activitiesService->getTotalNumberOfActivitiesInSystem();

            if ($nbActivitiesInSystem > 0)
            {

                //calculated percentage completed
                $percentageCompleted = ($nbCompletedActivities * 100) / $nbActivitiesInSystem;

            } else {

                $percentageCompleted = 0;

            }

            $screenData = app('clientContentSettigsSingleton')->getWorkExperienceIntro();

            return view('frontend.pages.work-experience.show', compact('nbCompletedActivities', 'nbActivitiesInSystem', 'percentageCompleted', 'screenData') );

        } else {

            return redirect()->route('frontend.dashboard');

        }

    }
}
