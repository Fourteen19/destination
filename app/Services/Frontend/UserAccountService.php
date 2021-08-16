<?php

namespace App\Services\Frontend;

use Illuminate\Support\Facades\Auth;


Class UserAccountService
{


    /**
     * checkIfUserHasChangedPassword
     * Checks if the user has changed their password after logging in the first time they used the system
     *
     * @return void
     */
    public function checkIfUserHasChangedPassword()
    {

        if (Auth::guard('web')->user()->password_reset == "Y")
        {
            return True;
        } else {
            return False;
        }

    }


    public function checkIfUserHasAcceptedTerms()
    {

        if (Auth::guard('web')->user()->accept_terms == "Y")
        {
            return True;
        } else {
            return False;
        }

    }

}
