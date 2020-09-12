<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
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
        return view('admin.auth.login');
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
        Log::info(Auth::guard('admin')->user()->full_name . " has logged in", ['admin_id' => Auth::guard('admin')->user()->id]);
    }


    /**
     * Overrides the logout function
     * Logout the admin.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {

        Log::info(Auth::guard('admin')->user()->full_name . " has logged out", ['admin_id' => Auth::guard('admin')->user()->id]);
                                
        Auth::guard('admin')->logout();

        return redirect()
            ->route('admin.login')
            ->with('status','Admin has been logged out!');
    
        }



}
