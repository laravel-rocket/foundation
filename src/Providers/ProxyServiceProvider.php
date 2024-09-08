<?php

namespace LaravelRocket\Foundation\Providers;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Symfony\Component\HttpFoundation\Request;

class ProxyServiceProvider extends BaseServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected bool $defer = false;

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $headers =
            Request::HEADER_X_FORWARDED_FOR |
            Request::HEADER_X_FORWARDED_HOST |
            Request::HEADER_X_FORWARDED_PORT |
            Request::HEADER_X_FORWARDED_PROTO |
            Request::HEADER_X_FORWARDED_AWS_ELB;

        $request = app('request');
        $trustedHeaderSet = config('proxy.headerSet', $headers);
        $proxies = config('proxy.trusted');

        if (!empty($proxies)) {
            if ($proxies === '*') {
                $proxies = [$request->getClientIp()];
            } elseif (!is_array($proxies)) {
                $proxies = [$proxies];
            }
            $request->setTrustedProxies($proxies, $trustedHeaderSet);
        }
    }
}
