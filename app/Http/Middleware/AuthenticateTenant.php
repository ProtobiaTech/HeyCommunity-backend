<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AuthenticateTenant
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
        if (Auth::tenant()->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('dashboard/log-in');
            }
        }

        return $next($request);
    }
}
