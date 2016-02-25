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
        $header = $request->header();
        $host = $header['host'][0];

        $Tenant = Tenant::where(['domain' => $host])->first();
        if (!$Tenant) {
            $Tenant = Tenant::where(['sub_domain' => $host])->first();
        }

        if ($Tenant) {
            TenantScope::addTenant('tenant_id', $Tenant->id);
        } else {
            if (env('APP_DEBUG')) {
                if (isset($_GET['tenant_id']) && $_GET['tenant_id']) {
                    TenantScope::addTenant('tenant_id', $_GET['tenant_id']);
                } else {
                    TenantScope::addTenant('tenant_id', 1);
                }
            } else {
                TenantScope::addTenant('tenant_id', 1);
            }
        }

        return $next($request);
    }
}
