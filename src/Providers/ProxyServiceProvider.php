<?php
namespace LaravelRocket\Foundation\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ProxyServiceProvider extends BaseServiceProvider
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
        $request          = app('request');
        $trustedHeaderSet = config('proxy.headerSet', Request::HEADER_X_FORWARDED_ALL);
        $proxies          = config('proxy.trusted');

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
