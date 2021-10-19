<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Validation\ValidationException;
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
        $this->middleware('guest:admin')->except('logout');
    }


    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }



    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.admin.failed')],
        ]);
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
        return Auth::guard('admin');
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

        //if the user is logged in && has not timed out
        if (Auth::guard('admin')->check())
        {
/*
            Log::info("Admin has logged in", [
                                            'admin_id' => Auth::guard('admin')->user()->id,
                                            'email' => Auth::guard('admin')->user()->email
            ]);*/

            // Store the Admin lelvel via a request instance
            // getAdminLevel is a helper function (app\helpers\rolePermissionHelper.php)
            if (!$request->session()->has('adminAccessLevel')) {
                $request->session()->put('adminAccessLevel', getAdminLevel($user) );
            }

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


        //if the user is logged in && has not timed out
        if (Auth::guard('admin')->check())
        {

            /* Log::info("Admin has logged out", [
                                            'admin_id' => Auth::guard('admin')->user()->id,
                                            'email' => Auth::guard('admin')->user()->email
            ]);*/

        }

        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()
            ->route('admin.login')
            ->with('status','Admin has been logged out!');



    }

}

