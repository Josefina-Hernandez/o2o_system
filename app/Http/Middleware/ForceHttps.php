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
        if (! empty($_SERVER['HTTP_X_FORWARDED_PROTO'])
            && $_SERVER["HTTP_X_FORWARDED_PROTO"] != 'https') {
            return redirect()->secure($request->getRequestUri());
        }

        return $next($request);
    }
}
