<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Laravel\Passport\Http\Middleware\CheckClientCredentials;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \App\Http\Middleware\CheckForMaintenanceMode::class,
        // \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \App\Http\Middleware\TrustProxies::class,
        \App\Http\Middleware\ForceHttps::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,

        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        // 'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'auth.basic' => \App\Http\Middleware\BasicAuthentication::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'credentialClient' => CheckClientCredentials::class,
        'checkPublishStatus' => \App\Http\Middleware\CheckPublishStatus::class,

		'estimate_maintenance' => \App\Http\Middleware\CheckForMaintenanceModeEstimate::class, // Add Estimate 20190718
		'check_cainz_shop' => \App\Http\Middleware\CheckCainzShop::class, // Add Estimate 20191017
		'check_cainz_shop_front' => \App\Http\Middleware\CheckCainzShopFront::class, // Add Estimate 20191017
		'remove_route_general' => \App\Http\Middleware\RemoveRouteGeneral::class, // Add Estimate 20191017

		'front.employee' => \App\Http\Middleware\Tostem\Front\RedirectIfAuthenticated::class,
        'front.auth' => \App\Http\Middleware\Tostem\Front\FrontAuthentication::class,
    ];
}
