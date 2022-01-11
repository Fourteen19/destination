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

        //if accessing the frontend site
        if ($subdomain != 'www')
        {

            //dd($request->session()->all());
            //gets client settings from REDIS
            $clientSettings = app('clientService')->getCachedClientSettings(Session::get('fe_client')['id']);

            $request->merge(array("clientSettings" => $clientSettings));

        } else {
            //dd($request->session()->all());
            $clientSettings = app('clientService')->getCachedClientSettings(1);
//dd($clientSettings);
        }

        //dd($subdomain);

        //dd($clientSettings);
        //$request->merge(array($clientSettings));
        return $next($request);
    }
}
