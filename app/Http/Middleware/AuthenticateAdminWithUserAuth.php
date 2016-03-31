<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AuthenticateAdminWithUserAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()->check() && Auth::user()->user()->id <= 4) {
            return $next($request);
        } else {
            return response('Insufficient permissions', 403);
        }
    }
}
