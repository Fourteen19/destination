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

        return app('clientContentSettingsSingleton')->getFooterDetails();

    }



    public function getPreFooterBlock()
    {

        return app('clientContentSettingsSingleton')->getPreFooterBlock();

    }


    public function getLoggedInPrefooter()
    {

        return app('clientContentSettingsSingleton')->getLoggedInPrefooter();

    }


    public function getPreFooterSupportBlock()
    {

        return app('clientContentSettingsSingleton')->getPreFooterSupportBlock();

    }

}
