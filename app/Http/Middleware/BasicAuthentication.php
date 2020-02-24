<?php
 
namespace App\Http\Middleware;
 
use App\Models\Shop;
use Closure;
use Illuminate\Http\Response;
 
class BasicAuthentication
{
    /**
    * Handle an incoming request.
    *
    * @param \Illuminate\Http\Request $request
    * @param \Closure $next
    * @return mixed
    */
    public function handle($request, Closure $next)
    {
        $prefCode = $request->route('pref_code');
        $shopCode = $request->route('shop_code');
        $shop = Shop::prefCode($prefCode)->code($shopCode)->first();

        if ($shop === null) {
            abort(404);
        }
        
        if ($shop->isStandardPreview()) {
            // Basic認証で受け取ったID/PWを取得する
            $user = $request->getUser();
            $pass = $request->getPassword();

            if ($user === config('app.basic_authentication_id')
                // config/app.phpに記載されているID/PWと合致すれば承認
                && $pass === config('app.basic_authentication_password')){
                return $next($request);
    
            } else {
                // 認証失敗のため再認証
                $headers = ['WWW-Authenticate' => 'Basic'];
                return new Response('Invalid credentials.', 401, $headers);
            }

        } else {
            // ショップがプレビューステータスでないので承認
            return $next($request);
        }
    }
}