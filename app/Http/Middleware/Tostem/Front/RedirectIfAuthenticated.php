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
    	if (Auth::guard($guard)->check() && \Auth::user()->isEmployee()) {
            return redirect()->route('tostem.front.quotation_system');
        }

        return $next($request);
    }
}