<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Artesaos\SEOTools\Facades\SEOMeta;
use App\Services\Frontend\AdvisorService;

class MeetYourAdviserController extends Controller
{

    protected $advisorService;

    /**
      * Create a new controller instance.
      *
      * @return void
    */
    public function __construct(AdvisorService $advisorService,) {
        $this->advisorService = $advisorService;
    }


    public function index()
    {

        SEOMeta::setTitle("Meet your adviser");

        $institutionAdvisorsdetails = $this->advisorService->getAdvisorDetailsForCurrentInstitution( Auth::guard('web')->user()->institution_id );
foreach($institutionAdvisorsdetails as $institutionAdvisordetails)
{

    //dd($institutionAdvisordetails->institutions->first()->pivot->introduction);

}
        return view('frontend.pages.my-account.meet-your-adviser', ['institutionAdvisorsdetails' => $institutionAdvisorsdetails]);

    }

}
