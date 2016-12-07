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
        if (!$this->setTenantByHost($request)) {
            if (!$this->setTenantByReferer($request)) {
                if (!$this->setTenantByParams($request)) {
                    $GLOBALS['Tenant'] = Tenant::findOrFail(38);
                    TenantScope::addTenant('tenant_id', $GLOBALS['Tenant']->id);
                }
            }
        }

        return $next($request);
    }

    /**
     *
     */
    public function setTenantByHost($request) {
        $host = $request->header()['host'][0];
        $Tenant = Tenant::where('domain', $host)->orWhere('sub_domain', $host)->first();

        if ($Tenant) {
            TenantScope::addTenant('tenant_id', $Tenant->id);
            $GLOBALS['Tenant'] = $Tenant;
            return true;
        } else {
            return false;
        }
    }

    /**
     *
     */
    public function setTenantByReferer($request) {
        $header = $request->header();

        if (isset($header['referer'])) {
            preg_match('/^http[s]?:\/\/([^\/]*)\//', $header['referer'][0], $tenantDomain);
            $referer = $tenantDomain[1];

            $Tenant = Tenant::where('domain', $referer)->orWhere('sub_domain', $referer)->first();
            if ($Tenant) {
                TenantScope::addTenant('tenant_id', $Tenant->id);
                $GLOBALS['Tenant'] = $Tenant;
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     *
     */
    public function setTenantByParams($request) {
        $domain = $request->domain;

        if ($domain) {
            $ret = preg_match('/^([^\/]*)[\/]?/', urldecode($domain));

            if ($ret) {
                $Tenant = Tenant::where('domain', $domain)->orWhere('sub_domain', $domain)->first();
                if ($Tenant) {
                    TenantScope::addTenant('tenant_id', $Tenant->id);
                    $GLOBALS['Tenant'] = $Tenant;
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
