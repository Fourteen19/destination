<?php

namespace App\Services\Frontend;

use Illuminate\Support\Facades\Auth;

Class AdvisorService
{

    public function __construct()
    {
        //
    }


    public function getAdvisorDetailsForCurrentUser()
    {

        //get all admins for the users institution
        return Auth::guard('web')->user()->institution->admins->first();

    }

}
