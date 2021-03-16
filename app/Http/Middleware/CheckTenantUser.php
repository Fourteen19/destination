<?php

namespace App\Http\Middleware;


use Closure;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;
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


        //if accessing the frontend site
        if ($subdomain != 'www')
        {

            // Retrieve requested tenant's info from database. If not found, abort the request.
            //->select('suspended')
            $client = Client::where('subdomain', $subdomain)->firstOrFail();

            if ($client->suspended == 'Y'){
                Auth::logout();
                //return redirect('/')->with('no_access', true);
            }

        //if accessing the backend
        } else {

            $client = NULL;

            //if the user does exists
            if (!is_null(Auth::user())){

                //if not a global admin user
                if (!isGlobalAdmin())
                {

                    $client = Client::where('id', Auth::guard('admin')->user()->client_id)->firstOrFail();

                    if ($client->suspended == 'Y'){
                        Auth::logout();
                    }
                }

            } else {

                Auth::logout();

            }

        }

        // if access ing the frontend site
        if (!Route::is('admin.*')){
            $request->session()->put('fe_client', $client);
        }



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
                    //prepares the clients dropdown
                    if(!$request->session()->has('all_clients'))
                    {

                        //selects all the clients
                        $clients = Client::select('id', 'uuid', 'name')->get()->toArray();

                        $clientsList = [];
                        foreach($clients as $key => $value)
                        {
                            $clientsList[ $value['uuid'] ] = $value['name'];

                            //sets the first client as default client to manage
                            if ($key == 0)
                            {
                                $request->session()->put('adminClientSelectorSelection',  $value['uuid']);
                                $request->session()->put('adminClientSelectorSelected', $value['id']);
                                $request->session()->put('client', $value );
                            }
                        }

                        //we store in a session all the current clients to appear in the client selector
                        $request->session()->put('all_clients',  $clientsList ); //Client::get()->pluck('name', 'uuid')->toArray()

                    }

                } else {

                    //selects all the clients
                    $clientAdmin = Client::select('id', 'uuid', 'name')->where('id', '=', $client->id)->first()->toArray();

                    $request->session()->put('adminClientSelectorSelection', $clientAdmin['uuid']);
                    $request->session()->put('adminClientSelectorSelected', $clientAdmin['id']);
                    $request->session()->put('adminClientName', $clientAdmin['name']);

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
