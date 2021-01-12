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

        //get all admins for the users institution
        $advisors = Auth::guard('web')->user()->institution->admins;

        $ContactableAdvisors = $advisors->filter(function ($value, $key) {
            return $value->contact_me == 1;
        });

        if ($ContactableAdvisors->count() > 0){
            $ContactableAdvisor = $ContactableAdvisors->first();
            $ContactableAdvisorName = $ContactableAdvisor->FullName;
            $canContactAdvisor = $ContactableAdvisor->contact_me;
        } else {
            $ContactableAdvisorName = "";
            $canContactAdvisor = 0;
        }

        $view->with('advisorName', $ContactableAdvisorName);
        $view->with('canContactAdvisor', $canContactAdvisor);

    }


}
