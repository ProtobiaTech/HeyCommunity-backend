<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use TenantScope;

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

        TenantScope::addTenant('tenant_id', Auth::tenant()->user()->id);
        return $next($request);
    }
}
