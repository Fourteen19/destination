<?php

namespace App\Http\Controllers\FrontEnd\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Artesaos\SEOTools\Facades\SEOMeta;
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
    public function __construct() {

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

        SEOMeta::setTitle("Login");

        $data = app('clientContentSettigsSingleton')->getLoginIntroText();

        return view('frontend.auth.login', ['intro_txt' => $data['login_intro']]);
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

        $authenticationPassed = False;

        $user = User::where('email', $request->email)->select('type')->first();

        if ($user)
        {

            if ($user->type == 'user')
            {

                if (Auth::attempt( [ 'email' => $request->email, 'password' => $request->password, 'client_id' => $clientId ] )) {
                    // Authentication passed...
                    $authenticationPassed = True;
                }

                if (Auth::attempt( [ 'personal_email' => $request->email, 'password' => $request->password, 'client_id' => $clientId ] )) {
                    // Authentication passed...
                    $authenticationPassed = True;
                }

            } else if ($user->type == 'admin'){

                if (Auth::attempt( [ 'email' => $request->email, 'password' => $request->password] )) {
                    // Authentication passed...
                    $authenticationPassed = True;
                }

            }

        }

        if ($authenticationPassed == True)
        {

            //updates the last date the user logged in
            Auth::guard('web')->user()->update(['last_login_date' => now(), 'nb_logins' => DB::raw('nb_logins + 1')]);

            Log::info("User has logged in", [
                'user_id' => Auth::guard('web')->user()->id,
                'email' => Auth::guard('web')->user()->email
            ]);

            //clears the dashboard from all articles
            Auth::guard('web')->user()->clearOrCreateDashboard('dashboard', 'something_different', 'hot_right_now', 'read_it_again');

            //stores the admin role of the user logging in
             if (Auth::guard('web')->user()->type == 'admin')
            {
                $role = Auth::guard('web')->user()->admin->getRoleNames()->first();
                $request->session()->put('admin_role', $role);
            } else {
                $request->session()->put('admin_role', "");
            }


            //redirects t the dashboard
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
/*    protected function authenticated(\Illuminate\Http\Request $request, $user)
    {


        if (Auth::user()->canGoToDashboard()){
            $this->redirectTo = RouteServiceProvider::DASHBOARD;
        } else {
            $this->redirectTo = RouteServiceProvider::WELCOME;
        }



        if (Auth::guard('web')->check()){

            $dashboardService = new DashboardService();

            $dashboardService->clearDashborad();

            Log::info("User has logged in", [
                                            'user_id' => Auth::guard('web')->user()->id,
                                            'email' => Auth::guard('web')->user()->email
                                    ]);
        }


    }
*/

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
