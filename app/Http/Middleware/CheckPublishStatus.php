<?php

namespace App\Http\Middleware;

use App\Models\Shop;
use Closure;

class CheckPublishStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $shop = Shop::code($request->route('shop_code'))->first();
        if ($shop === null
            || $shop->isStandardPrivate()) {
            abort(404);
        }

        return $next($request);
    }
}
