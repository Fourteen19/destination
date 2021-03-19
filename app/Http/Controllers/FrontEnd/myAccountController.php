<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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

        //Only if the user is of type `user`
        if (Auth::guard('web')->user()->type == 'user'){

            $institutionAdvisor = $this->advisorService->getAdvisorDetailsForCurrentUser();

        } elseif (Auth::guard('web')->user()->type == 'admin'){

            $institutionAdvisor = NULL;
        }

        return view('frontend.pages.my-account.edit', compact(['institutionAdvisor' => $institutionAdvisor]) );

    }


}
