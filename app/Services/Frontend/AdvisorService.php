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





    /**
     * getAdvisorDetailsForCurrentUser
     * get advisor details allocated to the user's institution
     *
     * @return void
     */
    public function getAdvisorDetailsForCurrentUser()
    {

        //get the advisor of the user's institution
        return Admin::adminTypeFromInstitution( config('global.admin_user_type.Advisor'), Auth::guard('web')->user()->institution_id )
                ->select('id', 'title', 'first_name', 'last_name', 'email', 'contact_me')
                ->with('media')
                ->get();

    }



    public function getAdvisorDetailsForCurrentInstitution($institutionId)
    {

        return Admin::adminTypeFromInstitution( config('global.admin_user_type.Advisor'), $institutionId )
                    ->select('id', 'uuid', 'title', 'first_name', 'last_name', 'email')
                    ->with(['institutions' => function ($q) use ($institutionId) {
                        $q->where('institution_id', $institutionId);
                        $q->withPivot('introduction','times_location');
                    }])
                    ->get();

    }


}
