<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Artesaos\SEOTools\Facades\SEOMeta;

class ContactAdviserController extends Controller
{
    /**
      * Create a new controller instance.
      *
      * @return void
    */
    public function __construct() {

    }


    public function index()
    {

        SEOMeta::setTitle("Contact my adviser");

        $redirect = 0;

        $institutionAdvisor = Auth::guard('web')->user()->institution->admins->first();
        if ($institutionAdvisor)
        {
            if ($institutionAdvisor->contact_me != 'Y')
            {
                $redirect = 1;
            }
        } else {
            $redirect = 1;
        }


        if ($redirect == 1)
        {
            return redirect()->route('frontend.my-account');
        }

        return view('frontend.pages.my-account.contact-my-adviser');

    }

}
