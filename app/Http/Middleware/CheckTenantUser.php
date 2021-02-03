<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use App\Models\Client;
use Illuminate\Http\Request;
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
            $has_access = $request->session()->get('has_access_admin', False);
            //dd( Session::all() );
        } else {
            $has_access = $request->session()->get('has_access_frontend');
        }
        if ($has_access) {
            return $next($request);
        }

        // Extract the subdomain from URL
        list($subdomain) = explode('.', $request->getHost(), 2);

        // Retrieve requested tenant's info from database. If not found, abort the request.
        $client = Client::where('subdomain', $subdomain)->firstOrFail();

        if ($client->suspended == 'Y'){
            Auth::logout();
            //return redirect('/')->with('no_access', true);
        }


        if (Route::is('admin.*')){
            // Store the tenant info into session.
            $request->session()->put('client', $client);
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
            $has_access = true;

            //if the current user is a global admin
            if (isGlobalAdmin())
            {
                //we store in a session all the current clients to appear in the client selector
                $request->session()->put('all_clients', Client::get()->pluck('name', 'uuid')->toArray() );
                $request->session()->put('adminClientSelectorSelection', $client->uuid);
                $request->session()->put('adminClientSelectorSelected', $client->id);
            }

        } else {
            $has_access = $request->user()->institution->client_id == $client->id;
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
