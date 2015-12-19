<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AuthenticateWithAdminAuth
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
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        } else {
            return redirect()->route('admin.auth.login');
        }
    }
}
