<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // laravel5.4から標準の文字セットがutf8からutf8mb4に変更され、
        // 1文字あたりのバイト数が4バイトに増えるため、varcharの最大長を191バイトに設定する
        Schema::defaultStringLength(191);

        // 強制的にHTTPS接続
        \URL::forceScheme('https');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // 検索文のパースを行うサービス
        $this->app->singleton('search_keywords', function () {
            return new \App\Services\SearchKeywordsService;
        });

        // 画像関連の機能を提供するサービス
        $this->app->bind('image_edit', function ($app) {
            return new \App\Services\ImageEditService;
        });

        // 画像を取得するサービス
        $this->app->bind('image_get', function ($app) {
            return new \App\Services\ImageGetService;
        });

        // TineMCE関連の機能を提供するサービス
        $this->app->bind('tinymce', function ($app) {
            return new \App\Services\TinyMceService;
        });

        // CSVの読み込みを行うサービス
        $this->app->bind('csv', function () {
            return new \App\Services\CsvService;
        });

        // 市区町村CSVの読み込みを行うサービス
        $this->app->bind('cities_csv', function () {
            return new \App\Services\CitiesCsvService;
        });

        // モデルの配列に対してカラムを指定し、
        // [id => 指定されたカラムの値]の連想配列を作成するサービス
        $this->app->bind('get_list', function () {
            return new \App\Services\GetListService;
        });
        
        // Userテーブルの新規IDと新規パスワードを取得するサービス
        $this->app->bind('user_id_and_password', function () {
            return new \App\Services\UserIdAndPasswordService;
        });
        
        //  Googleジオコードサービスの登録
        $this->app->bind("geocode",function(){
            return new \App\Services\GeocodeService;
        });

        // 事例を取得するサービス
        $this->app->bind("get_photo", function() {
            return new \App\Services\GetPhotosService;
        });

        // 記事を取得するサービス
        $this->app->bind("get_article", function() {
            return new \App\Services\GetArticlesService;
        });

        // 都道府県ごとにショップを取得するサービス
        $this->app->bind("get_shops_by_pref", function() {
            return new \App\Services\GetShopsByPrefService;
        });

        // 市区町村ごとにショップを取得するサービス
        $this->app->bind("get_shops_by_city", function () {
            return new \App\Services\GetShopsByCityService;
        });

        // CollectionやArrayに対して操作を行うクラス
        $this->app->bind("collection", function() {
            return new \App\Services\CollectionService;
        });

        // オートロードページを構成するクラス
        $this->app->bind("page_auto_load", function() {
            return new \App\Services\PageAutoLoadService;
        });

        // public配下のbladeをレンダーするクラス
        $this->app->bind("public_render", function() {
            return new \App\Services\PublicRenderService;
        });
    }
}
