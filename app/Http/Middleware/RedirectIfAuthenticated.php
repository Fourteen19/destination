<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            
            //if the route name starts with "admin.", redirects to theadmin dashboard
            if(\Route::is('admin.*')){
                if (Auth::guard($guard)->check()) {
                    return redirect(RouteServiceProvider::ADMIN_HOME);
                }
            } else {
                if (Auth::guard($guard)->check()) {
                    return redirect(RouteServiceProvider::HOME);
                }
            }
        }

        return $next($request);
    }

}
