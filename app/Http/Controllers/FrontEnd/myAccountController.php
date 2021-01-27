<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Services\Frontend\AdvisorService;

class myAccountController extends Controller
{

    protected $advisorService;

    /**
      * Create a new controller instance.
      *
      * @return void
    */
    public function __construct(AdvisorService $advisorService)
    {
        $this->advisorService = $advisorService;
    }



    public function index()
    {

        $institutionAdvisor = $this->advisorService->getAdvisorDetailsForCurrentUser();

        return view('frontend.pages.my-account.edit', compact(['institutionAdvisor' => $institutionAdvisor]) );

    }


}
