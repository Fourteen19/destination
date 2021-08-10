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

               // dd($institutionAdvisors);


                $displayMeetMyAdvisers = False;


                //copy the $institutionAdvisors collection
                $meetInstitutionAdvisorsCollection = $institutionAdvisors;

                //checks if any of the advisors has an introduction || times location
                $meetInstitutionAdvisors = $meetInstitutionAdvisorsCollection->filter(function ($value, $key) {
                    return ( (!empty($value->relatedInstitutionWithData->first()->pivot->introduction)) || (!empty($value->relatedInstitutionWithData->first()->pivot->times_location)) );
                });

                //if an adviser has some content attached to his institution profile, set the display to yes
                $displayMeetMyAdvisers = (!$meetInstitutionAdvisors->isEmpty()) ? True : False;


                $nbAdvisers = count($institutionAdvisors);

            } else {

                $institutionAdvisors = NULL;
                $advisorsContactThem = FALSE;
                $meetInstitutionAdvisors = NULL;
                $displayMeetMyAdvisers = FALSE;
                $nbAdvisers = 0;

            }

            $view->with('institutionAdvisors', $institutionAdvisors)
                 ->with('advisorsContactThem', $advisorsContactThem)
                 ->with('displayMeetMyAdvisers', $displayMeetMyAdvisers)
                 ->with('meetInstitutionAdvisors', $meetInstitutionAdvisors)
                 ->with('nbAdvisers', $nbAdvisers);

        }

    }


}
