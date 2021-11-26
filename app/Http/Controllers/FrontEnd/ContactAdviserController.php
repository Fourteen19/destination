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

        $redirect = 1;

        /*  $institutionAdvisor = Auth::guard('web')->user()->institution
                                    ->admins()->
                                    whereHas("roles", function($q){
                                        $q->where("name", config('global.admin_user_type.Advisor') );
                                    })->first(); */

        $institutionAdvisors = Auth::guard('web')->user()->institution->admins()->role( config('global.admin_user_type.Advisor') )->get();

        foreach ($institutionAdvisors as $institutionAdvisor)
        {

            if ($institutionAdvisor->contact_me == 'Y')
            {
                $redirect = 0;
            }

        }

        if ($redirect == 1)
        {
            return redirect()->route('frontend.my-account');
        }

        return view('frontend.pages.my-account.contact-my-adviser');

    }

}
