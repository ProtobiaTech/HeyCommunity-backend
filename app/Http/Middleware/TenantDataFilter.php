<?php

namespace App\Http\Middleware;

use Closure;
use TenantScope;

use App\Tenant;

class TenantDataFilter
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
        $host = $request->header()['host'][0];
        $Tenant = Tenant::where('domain', $host)->orWhere('sub_domain', $host)->first();
        if ($Tenant) {
            TenantScope::addTenant('tenant_id', $Tenant->id);
        } else {
            TenantScope::addTenant('tenant_id', 1);
        }

        return $next($request);
    }
}
