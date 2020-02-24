<?php

namespace App\Http\Middleware\Tostem\Front;
use Auth;

use Closure;

class FrontAuthentication
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
    	// dd($guard);
        /*if (!Auth::guard($guard)->check()) {
        	return redirect()->route('tostem.front.login');
        }*/

        return $next($request);
    }
}
