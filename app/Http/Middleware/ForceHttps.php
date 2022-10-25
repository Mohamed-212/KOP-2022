<?php

namespace App\Http\Middleware;

use Closure;

class ForceHttps
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
        if (!strpos($request->path(), 'api/broadcasting/auth') && !request()->isSecure()) {
            if (\Illuminate\Support\Facades\App::environment('production')) {
                return redirect()->secure($request->getRequestUri());
            }
        }

        return $next($request);
    }
}