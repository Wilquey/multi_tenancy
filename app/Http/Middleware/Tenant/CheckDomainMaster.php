<?php

namespace App\Http\Middleware\Tenant;

use Closure;

class CheckDomainMaster
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
        if (request()->getHost() == config('tenant.domain_main')) {

        };

        return $next($request);
    }
}
