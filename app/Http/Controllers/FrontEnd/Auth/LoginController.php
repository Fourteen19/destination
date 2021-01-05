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
        return view('frontend.auth.login');
    }


    /**
     * Custom function to check gather the users credentials
     *
     *
     *
     */
/*   public function credentials(\Illuminate\Http\Request $request)
    {

        $credentials = $request->only($this->email(), 'password');
        $credentials = array_add($credentials, 'institution_id', '1');
dd($credentials);
        return $credentials;
    }


    public function login(\Illuminate\Http\Request $request) {

        $credentials = $request->only($this->email(), 'password');
        $credentials = array_add($credentials, 'institution_id', '1');
//$this->credentials()
        if (Auth::attempt( $credentials )) {
dd("3333");
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
