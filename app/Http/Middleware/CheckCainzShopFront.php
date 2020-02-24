<?php

namespace App\Http\Middleware;

use Closure;
use App\Repositories\BaseRepository;

class CheckCainzShopFront
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
    	$base = new BaseRepository();
    	$pref_code = $request->pref_code;
    	$standard_shop_code = $request->shop_code;
    	$shop = $base->get_shop_id($pref_code, $standard_shop_code);
    	$shop_id = $shop['id'];
    	if($shop_id == NULL){
			return abort(404);
		}

		if(\HelpersCart::is_cainz_shop($shop_id)){
			return abort(404);
		}

        return $next($request);
    }
}