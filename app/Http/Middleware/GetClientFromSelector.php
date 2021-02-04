<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class GetClientFromSelector
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        //if admin is logged in
        if (Auth::guard('admin')->check())
        {

            //if admin is level 3, global admin
            if (isGlobalAdmin())
            {

                //dd( Session::all() );
                //determine if present in the session and is not null
                if ( Session::has('adminClientSelectorSelected') )
                {
                    $clientId = Session::get('adminClientSelectorSelected');
                } else {
                    // Extract the subdomain from URL
                    list($subdomain) = explode('.', $request->getHost(), 2);

                    // Retrieve requested tenant's info from database. If not found, abort the request.
                    $myclient = Client::where('subdomain', $subdomain)->firstOrFail();

                    $clientId = $myclient->id;
                }


            //else if client admin
            } elseif (isClientAdmin()){
                $clientId = Session::get('client')->id;
            }

           $request->attributes->add(['clientId' => $clientId]);

        }

        return $next($request);
    }
}
