<?php

namespace App\Providers;

use App\Services\CipherService;
use Illuminate\Support\ServiceProvider;

class HashServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // vendorで使用されているhashコンテナを上書きする
        $this->app->singleton('hash', function () {
            return new CipherService;
        });

        // 暗号化と復号化を行うサービスとして登録する
        $this->app->singleton('cipher', function () {
            return new CipherService;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['hash', 'cipher'];
    }
}