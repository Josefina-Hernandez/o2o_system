<?php

namespace App\Http\Middleware\Tostem\Front;

use Closure;

class CheckTokenExpired
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

    	if ($request->ajax()) {

    		// If request is an ajax request, then check to see if token matches token provider in
		    // the header. This way, we can use CSRF protection in ajax requests also.
    		$token = $request->ajax() ? $request->header('X-CSRF-Token') : $request->input('_token');

    		if($request->session()->token() != $token) {
    			return response()->json([
    				'msg' => __('validation.tokenexpired')
    			], 401);
    		}
    	}

        return $next($request);
    }
}
