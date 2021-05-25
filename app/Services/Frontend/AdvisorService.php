<?php

namespace App\Services\Frontend;

use App\Models\Admin\Admin;
use Illuminate\Support\Facades\Auth;

Class AdvisorService
{

    public function __construct()
    {
        //
    }


    public function getAdvisorDetailsForCurrentUser()
    {

        //get the advisor of the user's institution
        return Admin::adminTypeFromInstitution( config('global.admin_user_type.Advisor'), Auth::guard('web')->user()->institution_id )->first();

    }

}
