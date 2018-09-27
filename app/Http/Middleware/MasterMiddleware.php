<?php

namespace App\Http\Middleware;

use Closure;

class MasterMiddleware
{
    /**
     * Handle an incoming request
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (\Auth::guard($guard)->check() && user()->hasRole('master')) {
            return $next($request);
        }
        return redirect('/')->withError(trans('messages.access_denied_only_master'));
    }
}
