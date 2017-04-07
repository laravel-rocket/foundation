<?php

namespace LaravelRocket\Foundation\Http\Middleware;

use Closure;

class SecurePath
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
        $ua = $request->header('User-Agent');
        if (app()->environment('production') && !request()->secure() && strpos($ua, 'ELB-HealthChecker') === false) {
            // The environment is production
            return redirect()->secure(request()->path());
        }

        return $next($request);
    }
}
