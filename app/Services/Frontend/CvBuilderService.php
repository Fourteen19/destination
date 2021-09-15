<?php

namespace App\Services\Frontend;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

Class CvBuilderService
{

    public function __construct()
    {
        //
    }



    /**
     * getCvBuilderButtonLabel
     *
     * @return void
     */
    public function getCvBuilderButtonLabel()
    {

        $cvBuilderInfo = $this->getNbCvsForCurrentUser();

        if ($cvBuilderInfo->nb == 0)
        {
            $cvBuilderButtonLabel = "Get Started";
        } else {
            $cvBuilderButtonLabel = "Continue";
        }

        return $cvBuilderButtonLabel;
    }



    /**
     * getNbCvsForCurrentUser
     *
     * @return void
     */
    public function getNbCvsForCurrentUser()
    {
        return DB::table('cvs')
                ->select(array(DB::raw('COUNT(id) as nb')))
                ->where('user_id', '=', Auth::guard('web')->user()->id)
                ->first();
    }

}
