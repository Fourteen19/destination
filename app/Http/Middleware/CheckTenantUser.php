<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use App\Models\Client;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
class CheckTenantUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

       // dd( Session::all() );
        // Get has_access session (if available)
        // Session 'has_access' is only assigned if the user has previously granted access.
        // Therefore, 'pass' the request if the session is present

        if (Route::is('admin.*')){
            $guard = 'admin';
            $has_access = $request->session()->get('has_access_admin');
            //dd( Session::all() );
        } else {
            $guard = 'web';
            $has_access = $request->session()->get('has_access_frontend');
        }

        if ($has_access) {
            return $next($request);
        }



        // Extract the subdomain from URL
        list($subdomain) = explode('.', $request->getHost(), 2);
        if ($subdomain != 'www')
        {

            // Retrieve requested tenant's info from database. If not found, abort the request.
            $client = Client::where('subdomain', $subdomain)->firstOrFail();

            if ($client->suspended == 'Y'){
                Auth::logout();
                //return redirect('/')->with('no_access', true);
            }

        } else {
    /*
            if (Auth::guard($guard)->check())
            {

    //            $client = Auth::user();
                //dd($client);
            }
   */

            $client = NULL;

            if (!is_null(Auth::user())){

                if (!is_null(Auth::user()->client_id)){

                    $client = Client::where('client_id', Auth::user()->client_id )->firstOrFail();

                    if ($client->suspended == 'Y'){
                        Auth::logout();
                        //return redirect('/')->with('no_access', true);
                    }
                }

            } else {

                $client = NULL;

            }


        }



        if (Route::is('admin.*')){
            $request->session()->put('client', $client);
/*
            // Store the tenant info into session.
            if (Auth::guard($guard)->check())
            {
                if (!is_null(Auth::user()->client_id))
                {
                    $request->session()->put('client', $client);
                } else {
                    $request->session()->put('client', NULL);
                }

            }
*/
        } else {
            $request->session()->put('fe_client', $client);
        }

//dd( $request->session()->get('fe_client')->name );
        // If user not logged in, 'pass' and let application's auth logic runs
        if ($request->user() == null) {
            return $next($request);
        }

        //Checks if the logged in User has access to the tenant.
        // If not, redirects to login page with a error message.
        // Else, assign the 'has_access' session.

        if (Route::is('admin.*')){

            if (Auth::guard($guard)->check())
            {

                $has_access = true;

                //if the current user is a global admin
                if (isGlobalAdmin())
                {

                    //we store in a session all the current clients to appear in the client selector
                    $request->session()->put('all_clients', Client::get()->pluck('name', 'uuid')->toArray() );

                    $request->session()->put('adminClientSelectorSelection',  NULL);
                    $request->session()->put('adminClientSelectorSelected', NULL);
                    //$request->session()->put('adminClientSelectorSelection', (isset($client->uuid)) ? $client->uuid : NULL);
                    //$request->session()->put('adminClientSelectorSelected', (isset($client->id)) ? $client->id : NULL);
                }
            }

        } else {

            if (Auth::guard($guard)->check())
            {
                $has_access = $request->user()->institution->client_id == $client->id;
            }
        }



        if (!$has_access) {
            Auth::logout();
            return redirect('/login')->with('no_access', true);
        } else {

            if (Route::is('admin.*')){
                $request->session()->put('has_access_admin', true);
            } else {
                $request->session()->put('has_access_frontend', true);
            }

        }

        return $next($request);
    }

}
