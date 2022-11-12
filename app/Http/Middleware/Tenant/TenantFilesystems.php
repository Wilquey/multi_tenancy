<?php

namespace App\Http\Middleware\Tenant;

use Closure;

class TenantFilesystems
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
        if (request()->getHost() != config('tenant.domain_main')) {
            $this->setConfig();
        }

        return $next($request);
    }

    public function setConfig()
    {
        $uuid = session('company')['uuid'];
            
        config()->set([
            'filesystems.disks.tenant.root' => config('filesystems.disks.tenant.root') . "/{$uuid}",
            'filesystems.disks.tenant.url' => config('filesystems.disks.tenant.url') . "/{$uuid}",
        ]);
    }
}
