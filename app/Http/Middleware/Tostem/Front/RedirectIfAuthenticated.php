<?php

namespace App\Http\Middleware\Tostem\Front;
use Auth;

use Closure;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
    	if (Auth::guard($guard)->check()) {
            return redirect()->route('tostem.front.index');
        }

        return $next($request);
    }
}