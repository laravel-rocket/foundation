<?php
namespace LaravelRocket\Foundation\Providers;

use Illuminate\Support\ServiceProvider;

class ProxyServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     */
    public function register()
    {
        $request = app('request');
        $proxies = app('config')->get('proxy.trusted');
        if (!empty($proxies)) {
            if ($proxies === '*') {
                $proxies = [$request->getClientIp()];
            } elseif (!is_array($proxies)) {
                $proxies = [$proxies];
            }
            $request->setTrustedProxies($proxies);
        }
    }
}
