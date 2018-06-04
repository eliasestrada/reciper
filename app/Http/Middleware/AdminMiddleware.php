<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class AdminMiddleware
{
    // Handle an incoming request.
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check() && Auth::user()->admin === 1) {
			return $next($request);
        }
        return redirect('/recipes')->withError(
			trans('messages.only_admin_access')
		);
    }
}