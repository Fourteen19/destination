<?php

namespace App\Http\Controllers\FrontEnd\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
//use Illuminate\Contracts\Auth\PasswordBroker;
use App\Extensions\Passwords\CustomPasswordBroker;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Extensions\Passwords\CustomPasswordBrokerManager;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function showLinkRequestForm()
    {
        return view('frontend.auth.passwords.email');
    }


    public function sendResetLinkEmail(Request $request)
    {

        $this->validateEmail($request);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = app('auth.password')->sendResetLink(
            $this->credentials($request)
        );

        return $response == Password::RESET_LINK_SENT
                    ? $this->sendResetLinkResponse($request, $response)
                    : $this->sendResetLinkFailedResponse($request, $response);
    }




}
