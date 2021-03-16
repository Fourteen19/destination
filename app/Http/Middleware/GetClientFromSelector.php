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

                    ///determine if present in the session and is not null
                    if ( Session::has('all_clients') )
                    {

                        $firstClientUuid = count(Session::get('all_clients')) ? array_keys(Session::get('all_clients'))[0] : null;

                        // Retrieve requested tenant's info from database. If not found, abort the request.
                        $myclient = Client::select('id')->where('uuid', $firstClientUuid)->firstOrFail();

                        $clientId = $myclient->id;

                    } else {

                        $clientId = NULL;

                    }

                }



            //else if client admin
            } else {

                if ( Session::has('adminClientSelectorSelected') )
                {

                    $clientId = Session::get('adminClientSelectorSelected');

                }

                //$clientId = Session::get('client')['id'];
            }

            $request->attributes->add(['clientId' => $clientId]);

        }

        return $next($request);
    }
}
