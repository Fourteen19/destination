<?php

namespace App\Http\Controllers\FrontEnd\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('frontend.auth.login');
    }


    /**
     * Custom function to check gather the users credentials
     *
     *
     *
     */
 /*   public function credentials(Request $request)
    {

        $credentials = $request->only($this->email(), 'password');
        $credentials = array_add($credentials, 'institution_id', '1');

        return $credentials;
    }




    public function login($clientSubdomain) {
//die($clientSubdomain);
//die('456');

        if (Auth::attempt( $this->credentials() )) {

           // Authentication passed...
           return redirect()->intended('dashboard');
        }
     }
*/


    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(\Illuminate\Http\Request $request, $user)
    {

        Log::info("User has logged in", [
                                        'user_id' => Auth::user()->id,
                                        'email' => Auth::user()->email
        ]);

    }


    /**
     * Overrides the logout function
     * Logout the admin.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {

        Log::info("User has logged out", [
                                        'user_id' => Auth::user()->id,
                                        'email' => Auth::user()->email
        ]);

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()
            ->route('frontend.login')
            ->with('status','User has been logged out!');


    }

}
