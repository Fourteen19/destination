<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {

        if (! $request->expectsJson()) {
            
            //dd(\Route::current()->getName());
  
            //if coming from the backend
            //method Route::is() allows a pattern parameter
            if(\Route::is('admin.*')){
                return \Route('admin.login');
            }
            
            //else
            return \Route('login');

        }


    }
}
