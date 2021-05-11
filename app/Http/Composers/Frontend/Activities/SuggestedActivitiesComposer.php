<?php

namespace App\Http\Composers\Frontend\Activities;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Services\Frontend\ActivitiesService;

class SuggestedActivitiesComposer
{

    protected $activitiesService;

    public function __construct(ActivitiesService $activitiesService)
    {
        $this->activitiesService = $activitiesService;
    }


    public function compose(View $view)
    {

        //if the user is logged in
        if (Auth::guard('web')->check())
        {

            //if we are viewing an activity
            if (isset($view->getData()['content']))
            {
                //set $except so we do not include the activity in the list
                $except = [$view->getData()['content']->id];
            } else {
                $except = [];
            }

            $view->with('activities', $this->activitiesService->getStripeActivitiesNotCompletedByUser( Auth::guard('web')->user()->id, $except) );

        }

    }


}
