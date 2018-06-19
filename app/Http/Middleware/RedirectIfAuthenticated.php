<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class RedirectIfAuthenticated
{
    /** Handle an incoming request */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            return redirect('/login');
        }

        return $next($request);
    }
}
