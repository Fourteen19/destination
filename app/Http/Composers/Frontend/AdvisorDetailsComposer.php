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
            if (Auth::guard('web')->user()->institutionId)
            {
                $institutionAdvisor = $this->advisorService->getAdvisorDetailsForCurrentUser();

            } else {

                $institutionAdvisor = NULL;

            }

            $view->with('institutionAdvisor', $institutionAdvisor);

        }

    }


}
