<?php

namespace App\Http\Middleware;

use Closure;

class UserOnlineMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (auth()->check()) {
            if (user()->updated_at < now()->subMinutes(5)) {
                event(new \App\Events\UserIsOnline);
            }
            return $next($request);
        }
    }
}
