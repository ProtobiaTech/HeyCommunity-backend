<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Tenant;

class TenantController extends Controller
{
    /**
     * Get Tenant Info
     */
    public function getTenantInfo(Request $request)
    {
        $header = $request->header();
        $host = $header['host'][0];
        $model = Tenant::where('domain', $host)->orwhere('sub_domain', $host)->first();

        return $model;
    }
}
