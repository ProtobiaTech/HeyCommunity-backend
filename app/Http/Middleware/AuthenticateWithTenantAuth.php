<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AuthenticateWithTenantAuth
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
        if (Auth::tenant()->check()) {
            return $next($request);
        } else {
            return redirect()->route('admin.auth.login');
        }
    }
}
