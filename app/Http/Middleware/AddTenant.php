<?php

namespace App\Http\Middleware;

use Closure;

use App\Tenant;
use TenantScope;

class AddTenant
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
        $host = $request->header()['host'];
        $tenantModel = Tenant::where(['domain' => $host])->first();
        if ($tenantModel) {
            TenantScope::addTenant('tenant_id', $tenantModel->id);
        } else {
            if (env('APP_DEBUG')) {
                // in debug, not addTenant
            } else {
                TenantScope::addTenant('tenant_id', 0);
            }
        }

        return $next($request);
    }
}
