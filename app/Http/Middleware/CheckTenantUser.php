<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Client;
use Auth;


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

        // Get has_access session (if available)
        // Session 'has_access' is only assigned if the user has previously granted access.
        // Therefore, 'pass' the request if the session is present
        $has_access = $request->session()->get('has_access');
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

        // Store the tenant info into session.
        $request->session()->put('client', $client);

        // If user not logged in, 'pass' and let application's auth logic runs
        if ($request->user() == null) {
            return $next($request);
        }


        // Checks if the logged in User has access to the tenant.
        // If not, redirects to login page with a error message.
        // Else, assign the 'has_access' session.

        if(\Route::is('admin.*')){
            $has_access = true;
        } else {
            $has_access = $request->user()->institution->client_id == $client->id;
        }

        if (!$has_access) {
            Auth::logout();
            return redirect('/login')->with('no_access', true);
        } else {
            $request->session()->put('has_access', true);
        }

        return $next($request);
    }

}