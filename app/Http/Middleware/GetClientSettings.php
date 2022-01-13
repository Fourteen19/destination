<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class GetClientSettings
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        // Extract the subdomain from URL
        list($subdomain) = explode('.', $request->getHost(), 2);

        $clientSettings = [];

        //if accessing the frontend site
        if ($subdomain != 'www')
        {
            //gets client settings from REDIS
            //uses the value of the client drop-down set in the session
            $clientSettings = app('clientFrontendService')->getCachedClientSettings(Session::get('fe_client')['id']);

            $request->merge(array("clientSettings" => $clientSettings));

        } else {
            //gets client settings from REDIS
            //uses the value of the client drop-down set in the dashboard
            //$clientSettings = app('clientService')->getCachedClientSettings(session()->get('adminClientSelectorSelected'));


        }



        return $next($request);
    }
}
