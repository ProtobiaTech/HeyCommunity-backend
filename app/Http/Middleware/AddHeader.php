<?php

namespace App\Http\Middleware;

use Closure;

class AddHeader
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
        $response = $next($request);
        $response->header('Access-Control-Allow-Origin', env('HEADER_Access-Control-Allow-Origin'));
        $response->header('Access-Control-Allow-Method', env('HEADER_Access-Control-Allow-Method'));

        return $response;
    }
}
