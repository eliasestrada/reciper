<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthorMiddleware
{
    // Handle an incoming request.
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check() && Auth::user()->author === 1) {
			return $next($request);
        }
        return redirect('/');
    }
}