<?php

namespace App\Http\Composers\Frontend;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Services\Frontend\AdvisorService;

class AdvisorDetailsComposer
{

    protected $advisorService;

    public function __construct(AdvisorService $advisorService)
    {
        $this->advisorService = $advisorService;
    }


    public function compose(View $view)
    {

        //if the user is logged in
        if (Auth::guard('web')->check())
        {

            //if the user has an institution allocated
            //`admin` type users will not have an institution
            //`user` type users will have an institution
            if (Auth::guard('web')->user()->institution)
            {

                $institutionAdvisors = $this->advisorService->getAdvisorDetailsForCurrentUser();

                //indicates if at least 1 adviser is contactable
                $advisorsContactThem = $institutionAdvisors->contains(function ($value, $key) {
                    return $value->contact_me = "Y";
                });

                $nbAdvisers = count($institutionAdvisors);

            } else {

                $institutionAdvisors = NULL;
                $advisorsContactThem = FALSE;
                $nbAdvisers = 0;

            }

            $view->with('institutionAdvisors', $institutionAdvisors)
                 ->with('advisorsContactThem', $advisorsContactThem)
                 ->with('nbAdvisers', $nbAdvisers);

        }

    }


}
