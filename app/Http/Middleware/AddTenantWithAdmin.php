<?php

namespace App\Http\Middleware;

use Closure;

use App\Tenant;
use TenantScope;
use Auth;

class AddTenantWithAdmin
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
        TenantScope::addTenant('tenant_id', Auth::tenant()->user()->id);
        return $next($request);
    }
}
