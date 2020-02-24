<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades \{
    Auth,
    Route
};

class RedirectIfAuthenticated
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
        if (Auth::guard($guard)->check()) {
            $user = Auth::user();
            $currentRoute = Route::getCurrentRoute()->getName();

            // リダイレクト先のルートを決定する
            if (starts_with($currentRoute, 'admin.shop')) {
                // ショップ管理画面
                return redirect()->route('admin.shop', ['shop_id' => $user->shop_id]);

            } elseif (starts_with($currentRoute, 'admin.lixil')) {
                // LIXIL管理画面
                return redirect()->route('admin.lixil');

            } else {
                // admin.shopかadmin.lixilへのログインでなければ拒否する
            }

        }

        return $next($request);
    }
}
