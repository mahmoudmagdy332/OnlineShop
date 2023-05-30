<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if(! $request->expectsJson()){
            if ($request->is('admin/*')){
                return route('login.admin.view');
            }
            else{
               // redirect to front login
               return route('login.admin.view');
            }
        }
       // return $request->expectsJson() ? null : route('login.admin.view');
    }
}
