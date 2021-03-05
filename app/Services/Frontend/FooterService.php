<?php

namespace App\Services\Frontend;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

Class FooterService
{

    public function __construct()
    {
        //
    }


    public function getFooterDetails()
    {

        return app('clientContentSettigsSingleton')->getFooterDetails();

    }



    public function getPreFooterBlock()
    {

        return app('clientContentSettigsSingleton')->getPreFooterBlock();

    }


    public function getLoggedInPrefooter()
    {

        return app('clientContentSettigsSingleton')->getLoggedInPrefooter();

    }


    public function getPreFooterSupportBlock()
    {

        return app('clientContentSettigsSingleton')->getPreFooterSupportBlock();

    }

}
