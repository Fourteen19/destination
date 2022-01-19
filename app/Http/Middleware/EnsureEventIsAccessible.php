<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureEventIsAccessible
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

        // The user is logged in...
        if (!Auth::guard('web')->check())
        {
            //if the event is set to internal ie. do not show unless logged in
            if ($request->event->is_internal == "Y")
            {
                //redirect
                return abort(404);
            }

        }

        return $next($request);
    }
}
