<?php

namespace App\Http\Middleware;

use Closure;

class CheckCainzShop
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

    	// $param = $request->route()->parameters('shop_id');
    	$shop_id = \Auth::user()->shop_id;

    	if(\HelpersCart::is_cainz_shop($shop_id)){
    		return abort(404);
    	}

        return $next($request);
    }
}
