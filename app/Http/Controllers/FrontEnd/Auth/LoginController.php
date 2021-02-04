<?php

namespace App\Http\Controllers\FrontEnd\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = RouteServiceProvider::ADMIN_HOME;

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
     *
     * Sets the guard the authentication system is working with
     * In the admin environment, we work with the 'admin' guard
     * https://laravel.com/docs/7.x/authentication
     * @return
     */
    protected function guard()
    {
        return Auth::guard('web');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        $data = app('clientContentSettigsSingleton')->getLoginIntroText();

        return view('frontend.auth.login', ['intro_txt' => $data['login_intro']]);
    }


    /**
     * Custom function to check gather the users credentials
     *
     *
     *
     */
   public function credentials(\Illuminate\Http\Request $request)
    {
/*
        $credentials = $request->only($this->email(), 'password');
        $credentials = array_add($credentials, 'institution_id', '1');
*/
        return [
            'email' => $request->email,
            'password' => $request->password,
            'institution_id' => 1,
        ];

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'institution_id' => 1,
        ];

        if (Auth::attempt( $credentials )) {
           // Authentication passed...
           return redirect()->intended('dashboard');
        }

        $credentials = [
            'personal_email' => $request->email,
            'password' => $request->password,
            'institution_id' => 1,
        ];

        if (Auth::attempt( $credentials )) {
            // Authentication passed...
            return redirect()->intended('dashboard');
         }


//        return $credentials;
    }


    public function login(\Illuminate\Http\Request $request) {

        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $clientId = Session::get('fe_client')->id;

        if (Auth::attempt( [ 'email' => $request->email, 'password' => $request->password, 'institution_id' => $clientId ] )) {
           // Authentication passed...
           return redirect()->intended('dashboard');
        }


        if (Auth::attempt( [ 'personal_email' => $request->email, 'password' => $request->password, 'institution_id' => $clientId ] )) {
            // Authentication passed...
            return redirect()->intended('dashboard');
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
     }



    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(\Illuminate\Http\Request $request, $user)
    {


        if (Auth::user()->canGoToDashboard()){
            $this->redirectTo = RouteServiceProvider::DASHBOARD;
        } else {
            $this->redirectTo = RouteServiceProvider::WELCOME;
        }

        if (Auth::guard('web')->check()){

            Log::info("User has logged in", [
                                            'user_id' => Auth::guard('web')->user()->id,
                                            'email' => Auth::guard('web')->user()->email
                                    ]);
        }


    }


    /**
     * Overrides the logout function
     * Logout the admin.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {

        if (Auth::guard('web')->check()){

            Log::info("User has logged out", [
                                            'user_id' => Auth::guard('web')->user()->id,
                                            'email' => Auth::guard('web')->user()->email
            ]);

        }

        $subdomain = $request->session()->get('client.subdomain');

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()
            ->route('frontend.login', ['clientSubdomain' => $subdomain])
            ->with('status','User has been logged out!');


    }

}
