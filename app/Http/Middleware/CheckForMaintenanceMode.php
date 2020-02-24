<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CheckForMaintenanceMode
{
    /**
    * The application implementation.
    *
    * @var \Illuminate\Contracts\Foundation\Application
    */
    protected $app;
    
    /**
    * Create a new middleware instance.
    *
    * @param \Illuminate\Contracts\Foundation\Application $app
    * @return void
    */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // ここにアクセス許可したいIPアドレスを書く。複数の場合は['hoge','hoge']のように区切る
        $allow = array_map('trim', explode(',', env('MAINTENANCE_ALLOW_IP')));

        if ($this->app->isDownForMaintenance() && !in_array($request->getClientIp(), $allow)) {
            throw new HttpException(503);
        }else{
            return $next($request);
        }
        
    }
}