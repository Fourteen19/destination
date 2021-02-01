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


    public function getFooterDetailsForCurrentClient()
    {

        return Session::get('fe_client')->staticClientContent()->select('tel', 'email', 'show_terms', 'show_privacy', 'show_cookies')->first()->toArray();

    }

}
