<?php
namespace LaravelRocket\Foundation\Http\Middleware;

use Closure;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $locale = \LocaleHelper::getLocale();
        app()->setLocale($locale);

        return $next($request);
    }
}
