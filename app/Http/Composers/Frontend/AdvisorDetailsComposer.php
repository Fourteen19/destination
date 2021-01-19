<?php

namespace App\Http\Composers\Frontend;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class AdvisorDetailsComposer
{

    public function __construct()
    {

    }


    public function compose(View $view)
    {

        if (Auth::guard('web')->check())
        {

            //ADVISOR CONTACT DETAILS

            $ContactableAdvisorName = "";
            $canContactAdvisor = 0;

            //get all admins for the users institution
            $institutionAdvisor = Auth::guard('web')->user()->institution->admins->first();

            if ($institutionAdvisor)
            {

                if ($institutionAdvisor->contact_me == 'Y')
                {

                    $ContactableAdvisorName = $institutionAdvisor->titleFullName;
                    $canContactAdvisor = $institutionAdvisor->contact_me;

                }

            }

            $view->with('advisorName', $ContactableAdvisorName);
            $view->with('canContactAdvisor', $canContactAdvisor);

            //////////////////


        }

    }


}
