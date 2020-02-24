<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\AdminUserAccessPolicy;
use App\Providers\MadoEloquentUserProvider;
use Illuminate\Support\Facades \{
    Auth,
    Gate
};
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => AdminUserAccessPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        /**
         * 認証
         */
        // 管理画面ログイン時にLIXILとショップの認証を分離するため、
        // EloquentUserProviderを継承したProviderを定義する
        Auth::provider('madoEloquent', function ($app, array $config) {
            return new MadoEloquentUserProvider($app['hash'], $config['model']);
        });

        /**
         * 認可: laravel/passport
         */
        // laravel/passportのルートにprefixとして api/ を付与する
        Passport::routes(null, [
            'prefix' => 'api/oauth',
            'namespace' => '\Laravel\Passport\Http\Controllers',
        ]);
        // トークンの有効期限を設定する
        Passport::tokensExpireIn(now()->addMinutes(10));

        /**
         * 認可: ゲート
         */
        // ゲートの定義
        Gate::define('suitableShop', 'App\Policies\AdminUserAccessPolicy@suitableShop');
        Gate::define('standard', 'App\Policies\AdminUserAccessPolicy@standard');
        Gate::define('premium', 'App\Policies\AdminUserAccessPolicy@premium');
        Gate::define('standardOrPremium', 'App\Policies\AdminUserAccessPolicy@standardOrPremium');
        Gate::define('lixil', 'App\Policies\AdminUserAccessPolicy@lixil');
        Gate::define('employee', 'App\Policies\AdminUserAccessPolicy@employee');
    }
}
