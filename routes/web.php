<?php


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// 認証関連のページは独自にルーティングするため、Auth::routes()を呼び出さない
// Auth::routes();

/**
 * フロント画面
 * {domain}/(?! admin/)*
 */
Route::name('front')->namespace('Mado\Front')->group(function () {


    // フロントTOP
    Route::get('/', ['as' => '', 'uses' => 'IndexController@index']);
    Breadcrumbs::add('front', function ($request) {
        return [route('front'), 'LIXIL簡易見積りシステムTOP'];
    });

    // サイトマップ
    Route::get('/sitemap', ['as' => '.sitemap', 'uses' => 'IndexController@sitemap']);
    Breadcrumbs::add('front.sitemap', function ($request) {
        return [route('front.sitemap'), 'サイトマップ'];
    }, 'front');

    /**
     * LIXILからのお知らせ
     * {domain}/news*
     */
    Route::prefix('/news')->name('.news')->group(function () {
        // LIXILからのお知らせ
        Route::get('', ['as' => '', 'uses' => 'NewsController@index']);

        // LIXILからのお知らせ詳細
        Route::get('/{date}', ['as' => '.detail', 'uses' => 'NewsController@detail'])->where('date', '[0-9]{12}');
    });

    /**
     * LIXILお問い合わせフォーム
     * {domain}/contact*
     */
    Route::prefix('/contact')->name('.contact')->group(function () {
        // LIXIL お問い合わせ
        Route::match(['GET', 'POST'], '/', ['as' => '', 'uses' => 'ContactController@index']);
        Breadcrumbs::add('front.contact', function ($request) {
            return [route('front.contact'), 'お問い合わせ'];
        }, 'front');

        // LIXIL お問い合わせ確認
        Route::post('/confirm', ['as' => '.confirm', 'uses' => 'ContactController@confirm']);
        Breadcrumbs::add('front.contact.confirm', function ($request) {
            return [route('front.contact.confirm'), 'お問い合わせ'];
        }, 'front');

        // LIXIL お問い合わせ完了
        Route::post('/complete', ['as' => '.complete', 'uses' => 'ContactController@complete']);
        Breadcrumbs::add('front.contact.complete', function ($request) {
            return [route('front.contact.complete'), 'お問い合わせ'];
        }, 'front');
    });

    /**
     * プライバシーポリシー
     * {domain}/privacy
     */
    Route::get('/privacy', ['as' => '.privacy', 'uses' => 'IndexController@privacy']);
    Breadcrumbs::add('front.privacy', function ($request) {
        return [route('front.privacy'), 'LIXIL簡易見積りシステム プライバシーポリシー'];
    }, 'front');

    /**
     * ショップが関連するページ
     * {domain}/shop/*
     */
    Route::prefix('/shop')->name('.shop')->namespace('Shop')->group(function () {

        /**
         * ショップ検索
         * {domain}/shop/search*
         */
        Route::prefix('/search')->name('.search')->group(function () {

            // ショップ検索: 日本地図モーダルウィンドウ
            Route::get('/modal', ['as' => '.modal', 'uses' => 'IndexController@prefModal']);

            // ショップ検索: 日本地図モーダルウィンドウ（見積りシミュレーション絞り込み）
            Route::get('/estimate_modal', ['as' => '.modal.estimate', 'uses' => 'IndexController@prefModalEstimate']);

            // ショップ検索 都道府県絞り込み
            Route::get('/{pref_code}', ['as' => '.pref', 'uses' => 'IndexController@searchPref'])->where('pref_code', '[a-z]+');
            Breadcrumbs::add('front.shop.search.pref', function ($request) {
                $prefCode = $request->route('pref_code');
                $pref = \App\Models\Pref::code($prefCode)->first();
                return [
                    route('front.shop.search.pref', ['pref_code' => $prefCode]),
                    $pref->{config('const.db.prefs.NAME')} . 'のLIXIL簡易見積りシステム一覧'
                ];
            }, 'front');

            // ショップ検索 市区町村絞り込み
            Route::get('/{pref_code}/{city_code}', ['as' => '.city', 'uses' => 'IndexController@searchCity'])->where(['pref_code' => '[a-z]+', 'city_code' => '[0-9]{5}']);
            Breadcrumbs::add('front.shop.search.city', [
                function ($request) {
                    $prefCode = $request->route('pref_code');
                    $pref = \App\Models\Pref::code($prefCode)->first();

                    // ｛都道府県｝のLIXIL簡易見積りシステム一覧
                    return [
                        route('front.shop.search.pref', ['pref_code' => $prefCode]),
                        $pref->{config('const.db.prefs.NAME')} . 'のLIXIL簡易見積りシステム一覧'
                    ];
                },
                function ($request) {
                    $cityCode = $request->route('city_code');
                    $city = \App\Models\City::code($cityCode)->first();

                    // ｛市区町村｝のLIXIL簡易見積りシステム一覧
                    return [
                        route('front.shop.search.city', ['pref_code' => $request->route('pref_code'), 'city_code' => $cityCode]),
                        $city->{config('const.db.cities.NAME')} . 'のLIXIL簡易見積りシステム一覧'
                    ];
                },
            ], 'front');

            // ショップ検索 キーワード絞り込み
            Route::get('/', ['as' => '.keyword', 'uses' => 'IndexController@searchKeyword']);
            Breadcrumbs::add('front.shop.search.keyword', function ($request) {
                return [route('front.shop.search.keyword'), '検索結果'];
            }, 'front');

        });


        /**
         * 全国の施工事例
         * {domain}/shop/photo*
         */
        Route::prefix('/photo')->name('.photo')->group(function () {

            // 施工事例一覧
            Route::get('/', ['as' => '', 'uses' => 'IndexController@photo']);
            Breadcrumbs::add('front.shop.photo', function ($request) {
                return [route('front.shop.search.keyword'), '全国の施工事例一覧'];
            }, 'front');

            // 施工事例検索 キーワード絞り込み
            Route::get('/search', ['as' => '.search', 'uses' => 'IndexController@searchPhoto']);
            Breadcrumbs::add('front.shop.photo.search', function ($request) {
                return [route('front.shop.search.keyword'), '施工事例検索結果'];
            }, 'front');

        });

        // 現場ブログ一覧
        Route::get('/blog', ['as' => '.blog', 'uses' => 'IndexController@article']);
        Breadcrumbs::add('front.shop.blog', function ($request) {
            return [route('front.shop.blog'), '全国の現場ブログ'];
        }, 'front');

        // イベントキャンペーン一覧
        Route::get('/event', ['as' => '.event', 'uses' => 'IndexController@article']);
        Breadcrumbs::add('front.shop.event', function ($request) {
            return [route('front.shop.event'), '全国のイベント・キャンペーン'];
        }, 'front');

        /**
         * スタンダードショップのページ
         * {domain}/shop/{pref_code}/{shop_code}*
         */
        Route::middleware('checkPublishStatus', 'auth.basic')->prefix('/{pref_code}/{shop_code}')->name('.standard')->namespace('Standard')->group(function ($group) {

            // ショップ詳細
            Route::get('/', ['as' => '', 'uses' => 'IndexController@index']);
            Breadcrumbs::add('front.shop.standard', [
                function ($request) {
                    $prefCode = $request->route('pref_code');
                    $pref = \App\Models\Pref::code($prefCode)->first();

                    // ｛都道府県｝のLIXIL簡易見積りシステム一覧
                    return [
                        route('front.shop.search.pref', ['pref_code' => $prefCode]),
                        $pref->{config('const.db.prefs.NAME')} . 'のLIXIL簡易見積りシステム一覧'
                    ];
                },
                function ($request) {
                    $shop = \App\Models\Shop::code($request->route('shop_code'))->first();
                    // ｛市区町村｝のLIXIL簡易見積りシステム一覧
                    return [
                        route('front.shop.search.city', ['pref_code' => $request->route('pref_code'), 'city_code' => $shop->city->{config('const.db.cities.CODE')}]),
                        $shop->city->{config('const.db.cities.NAME')} . 'のLIXIL簡易見積りシステム一覧'
                    ];
                },
                function ($request) {
                    $shop = \App\Models\Shop::code($request->route('shop_code'))->first();
                    if ('front.shop.standard' === $request->route()->getName()) {
                        // ｛加盟店名｝TOP
                        return [
                            route('front.shop.standard', ['pref_code' => $request->route('pref_code'), 'shop_code' => $request->route('shop_code')]),
                            $shop->{config('const.db.shops.NAME')} . "&nbsp;" . 'TOP'
                        ];

                    } else {
                        // ｛加盟店名｝
                        return [
                            route('front.shop.standard', ['pref_code' => $request->route('pref_code'), 'shop_code' => $request->route('shop_code')]),
                            $shop->{config('const.db.shops.NAME')}
                        ];
                    }
                },
            ], 'front');

            // お知らせ一覧
            Route::get('/news', ['as' => '.news', 'uses' => 'IndexController@news']);
            Breadcrumbs::add('front.shop.standard.news', function ($request) {
                return [
                    route('front.shop.standard.news', ['pref_code' => $request->route('pref_code'), 'shop_code' => $request->route('shop_code')]),
                    'お知らせ一覧'
                ];
            }, 'front.shop.standard');


            /**
             * 現場ブログ
             * {domain}/shop/{pref_code}/{shop_code}/blog*
             */
            Route::prefix('/blog')->name('.blog')->group(function ($group) {

                // 現場ブログ一覧
                Route::get('/', ['as' => '', 'uses' => 'ArticleController@index']);
                Breadcrumbs::add('front.shop.standard.blog', function ($request) {
                    return [
                        route('front.shop.standard.blog', ['pref_code' => $request->route('pref_code'), 'shop_code' => $request->route('shop_code')]),
                        '現場ブログ一覧'
                    ];
                }, 'front.shop.standard');


                // 現場ブログ詳細
                Route::get('/{article_id}', ['as' => '.detail', 'uses' => 'ArticleController@detail'])->where('article_id', '[0-9]+');
                Breadcrumbs::add('front.shop.standard.blog.detail', function ($request) {
                    return [
                        route('front.shop.standard.blog', ['pref_code' => $request->route('pref_code'), 'shop_code' => $request->route('shop_code'), 'article_id' => $request->route('article_id')]),
                        '現場ブログ'
                    ];
                }, 'front.shop.standard');
            });

            /**
             * イベントキャンペーン
             * {domain}/shop/{pref_code}/{shop_code}/event*
             */
            Route::prefix('/event')->name('.event')->group(function ($group) {

                // イベントキャンペーン一覧
                Route::get('/', ['as' => '', 'uses' => 'ArticleController@index']);
                Breadcrumbs::add('front.shop.standard.event', function ($request) {
                    return [
                        route('front.shop.standard.event', ['pref_code' => $request->route('pref_code'), 'shop_code' => $request->route('shop_code')]),
                        'イベントキャンペーン一覧'
                    ];
                }, 'front.shop.standard');


                // イベントキャンペーン詳細
                Route::get('/{article_id}', ['as' => '.detail', 'uses' => 'ArticleController@detail'])->where('article_id', '[0-9]+');
                Breadcrumbs::add('front.shop.standard.event.detail', function ($request) {
                    return [
                        route('front.shop.standard.event', ['pref_code' => $request->route('pref_code'), 'shop_code' => $request->route('shop_code'), 'article_id' => $request->route('article_id')]),
                        'イベントキャンペーン'
                    ];
                }, 'front.shop.standard');
            });

            /**
             * スタッフ紹介
             * {domain}/shop/{pref_code}/{shop_code}/staff
             */
            Route::get('/staff', ['as' => '.staff', 'uses' => 'IndexController@staff']);
            Breadcrumbs::add('front.shop.standard.staff', function ($request) {
                return [
                    route('front.shop.standard.staff', ['pref_code' => $request->route('pref_code'), 'shop_code' => $request->route('shop_code')]),
                    'スタッフ紹介'
                ];
            }, 'front.shop.standard');


            /**
             * 施工事例
             * {domain}/shop/{pref_code}/{shop_code}/photo*
             */
            Route::prefix('/photo')->name('.photo')->group(function () {

                // 施工事例一覧
                Route::get('/', ['as' => '', 'uses' => 'PhotoController@index']);
                Breadcrumbs::add('front.shop.standard.photo', function ($request) {
                    return [
                        route('front.shop.standard.photo', ['pref_code' => $request->route('pref_code'), 'shop_code' => $request->route('shop_code')]),
                        '施工事例一覧'
                    ];
                }, 'front.shop.standard');

                // 施工事例検索
                Route::get('/search', ['as' => '.search', 'uses' => 'PhotoController@search']);
                Breadcrumbs::add('front.shop.standard.photo.search', function ($request) {
                    return [
                        route('front.shop.standard.photo', ['pref_code' => $request->route('pref_code'), 'shop_code' => $request->route('shop_code')]),
                        '施工事例検索結果'
                    ];
                }, 'front.shop.standard');

                // 施工事例詳細
                Route::get('/{photo_id}', ['as' => '.detail', 'uses' => 'PhotoController@detail'])->where('photo_id', '[0-9]+');
                Breadcrumbs::add('front.shop.standard.photo.detail', function ($request) {
                    return [
                        route('front.shop.standard.photo', ['pref_code' => $request->route('pref_code'), 'shop_code' => $request->route('shop_code'), 'photo_id' => $request->route('photo_id')]),
                        '施工事例'
                    ];
                }, 'front.shop.standard');

            });


            /**
             * お問い合わせフォーム
             * {domain}/shop/{pref_code}/{shop_code}/contact*
             */
            Route::prefix('/contact')->name('.contact')->group(function () {

                // お問い合わせ
                Route::match(['GET', 'POST'], '/', ['as' => '', 'uses' => 'ContactController@index']);
                Breadcrumbs::add('front.shop.standard.contact', function ($request) {
                    return [
                        route('front.shop.standard.contact', ['pref_code' => $request->route('pref_code'), 'shop_code' => $request->route('shop_code')]),
                        'お問い合わせ'
                    ];
                }, 'front.shop.standard');

                // お問い合わせ確認
                Route::post('/confirm', ['as' => '.confirm', 'uses' => 'ContactController@confirm']);
                Breadcrumbs::add('front.shop.standard.contact.confirm', function ($request) {
                    return [
                        route('front.shop.standard.contact', ['pref_code' => $request->route('pref_code'), 'shop_code' => $request->route('shop_code')]),
                        'お問い合わせ'
                    ];
                }, 'front.shop.standard');

                // お問い合わせ完了 メールを送信する
                Route::post('/complete', ['as' => '.complete', 'uses' => 'ContactController@complete']);
                Breadcrumbs::add('front.shop.standard.contact.complete', function ($request) {
                    return [
                        route('front.shop.standard.contact', ['pref_code' => $request->route('pref_code'), 'shop_code' => $request->route('shop_code')]),
                        'お問い合わせ'
                    ];
                }, 'front.shop.standard');

            });


            // where()はメソッドチェーンできないため、ルートを定義してから再度取得し、各ルートのwhere()を呼び出す
            // prefix()等はRouterクラスのメソッドであるが、where()はRouteクラスのメソッドであるという点で異なる
            foreach ($group->getRoutes() as $route) {
                $route->where(['pref_code' => '[a-z]+', 'shop_code' => '[0-9a-zA-Z-]+']);
            }

        });

    });

});


/**
 * 加盟店管理画面
 * {domain}/admin/shop/*
 */
Route::prefix('admin/shop')->name('admin.shop')->namespace('Mado\Admin\Shop')->group(function () {
    // ログイン/ログアウト
    Route::get('/login', ['as' => '.login', 'uses' => 'LoginController@showLoginForm']);
    Route::post('/login', ['as' => '.auth', 'uses' => 'LoginController@login']);
    Route::post('/logout', ['as' => '.logout', 'uses' => 'LoginController@logout']);
});

Route::middleware('auth', 'can:suitableShop,shop_id')->prefix('admin/shop/{shop_id}')->name('admin.shop')->namespace('Mado\Admin\Shop')->group(function ($group) {
    // 共通: スタンダードもプレミアムもアクセス可能
    Route::middleware('can:standardOrPremium')->group(function () {

        // 加盟店マイページTOP
        Route::get('/', ['as' => '', 'uses' => 'IndexController@index']);

        /**
         * 加盟店情報管理
         */
        Route::prefix('/company')->group(function () {

            // 加盟店情報編集
            Route::match(['GET', 'POST'], '/edit', ['as' => '.edit', 'uses' => 'ShopController@edit']);

            // 加盟店情報編集確認
            Route::post('/confirm', ['as' => '.confirm', 'uses' => 'ShopController@confirm']);

            // 加盟店情報編集完了 DBのショップ情報を更新する
            Route::post('/complete', ['as' => '.complete', 'uses' => 'ShopController@complete']);

        });

    });

    // スタンダードのみアクセス可能
    Route::middleware('can:standard')->group(function () {

        /**
         * 施工事例管理
         */
        Route::prefix('/photo')->name('.photo')->group(function () {

            // 施工事例一覧
            Route::get('/', ['as' => '', 'uses' => 'PhotoController@index']);


            // 施工事例新規登録
            Route::match(['GET', 'POST'], '/new', ['as' => '.new', 'uses' => 'PhotoController@new']);

            // 施工事例新規登録確認
            Route::post('/confirm', ['as' => '.confirm', 'uses' => 'PhotoController@confirm']);

            // 施工事例新規登録完了 DBに施工事例情報を保存する
            Route::post('/complete', ['as' => '.complete', 'uses' => 'PhotoController@complete']);


            Route::prefix('/{photo_id}')->group(function ($group) {
                Route::name('.edit')->group(function () {
                    // 施工事例編集
                    Route::match(['GET', 'POST'], '/edit', ['as' => '', 'uses' => 'PhotoController@edit']);

                    // 施工事例編集確認
                    Route::post('/confirm', ['as' => '.confirm', 'uses' => 'PhotoController@editConfirm']);

                    // 施工事例編集完了 DBに施工事例情報を保存する
                    Route::post('/complete', ['as' => '.complete', 'uses' => 'PhotoController@editComplete']);
                });

                // 施工事例削除 DBの施工事例情報を論理削除する
                Route::post('/delete', ['as' => '.delete', 'uses' => 'PhotoController@delete']);

                // where()はメソッドチェーンできないため、ルートを定義してから再度取得し、各ルートのwhere()を呼び出す
                // prefix()等はRouterクラスのメソッドであるが、where()はRouteクラスのメソッドであるという点で異なる
                foreach ($group->getRoutes() as $route) {
                    $route->where('photo_id', '[0-9]+');
                }

            });

        });


        /**
         * 現場ブログ・イベントキャンペーン管理
         */
        Route::prefix('/article')->name('.article')->group(function () {

            // 現場ブログ・イベントキャンペーン一覧
            Route::get('/', ['as' => '', 'uses' => 'ArticleController@index']);


            // 現場ブログ・イベントキャンペーン新規登録
            Route::match(['GET', 'POST'], '/new', ['as' => '.new', 'uses' => 'ArticleController@new']);

            // 現場ブログ・イベントキャンペーン新規登録完了 DBに現場ブログ・イベントキャンペーン情報を保存する
            Route::post('/complete', ['as' => '.complete', 'uses' => 'ArticleController@complete']);


            Route::prefix('/{article_id}')->group(function ($group) {
                Route::name('.edit')->group(function () {
                    // 現場ブログ・イベントキャンペーン編集
                    Route::match(['GET', 'POST'], '/edit', ['as' => '', 'uses' => 'ArticleController@edit']);

                    // 現場ブログ・イベントキャンペーン編集完了 DBに現場ブログ・イベントキャンペーン情報を保存する
                    Route::post('/complete', ['as' => '.complete', 'uses' => 'ArticleController@editComplete']);
                });

                // 現場ブログ・イベントキャンペーン削除 DBの現場ブログ・イベントキャンペーン情報を論理削除する
                Route::post('/delete', ['as' => '.delete', 'uses' => 'ArticleController@delete']);

                // where()はメソッドチェーンできないため、ルートを定義してから再度取得し、各ルートのwhere()を呼び出す
                // prefix()等はRouterクラスのメソッドであるが、where()はRouteクラスのメソッドであるという点で異なる
                foreach ($group->getRoutes() as $route) {
                    $route->where('article_id', '[0-9]+');
                }

            });

        });


        /**
         * お知らせ管理
         */
        Route::prefix('/news')->name('.news')->group(function () {

            // お知らせ管理
            Route::get('/', ['as' => '', 'uses' => 'NewsController@index']);

            // お知らせ管理 DBのお知らせ情報を保存する
            Route::post('/', ['as' => '.register', 'uses' => 'NewsController@register']);

            // お知らせ管理編集 DBのお知らせ情報を取得する
            Route::get('/{notice_id}/edit', ['as' => '.edit', 'uses' => 'NewsController@edit'])->where('notice_id', '[0-9]+');

            // お知らせ管理 DBのお知らせ情報を論理削除する
            Route::post('/{notice_id}/delete', ['as' => '.delete', 'uses' => 'NewsController@delete'])->where('notice_id', '[0-9]+');

        });


        /**
         * 緊急メッセージ編集
         */
        Route::prefix('/message')->name('.message')->group(function () {

            // 緊急メッセージ編集
            Route::get('/', ['as' => '', 'uses' => 'MessageController@index']);

            // 緊急メッセージ編集 DBに緊急メッセージ情報を保存する
            Route::post('/', ['as' => '.edit', 'uses' => 'MessageController@edit']);

        });


        /**
         * スタッフ管理
         */
        Route::prefix('/staff')->name('.staff')->group(function () {

            // スタッフ管理TOP
            Route::get('/', ['as' => '', 'uses' => 'StaffController@index']);

            // スタッフ登録ボタン DBにスタッフ情報を登録・更新・論理削除する
            Route::post('/', ['as' => '.edit', 'uses' => 'StaffController@edit']);

        });

        /**
         * バナー管理
         */
        Route::prefix('/banner')->name('.banner')->group(function () {

            // バナー管理TOP
            Route::get('/', ['as' => '', 'uses' => 'BannerController@index']);

            // バナー登録ボタン DBにバナー情報を登録・更新・論理削除する
            Route::post('/', ['as' => '.edit', 'uses' => 'BannerController@edit']);

        });

    });

    // プレミアムのみアクセス可能
    Route::middleware('can:premium')->group(function () {
        //
    });

    // where()はメソッドチェーンできないため、ルートを定義してから再度取得し、各ルートのwhere()を呼び出す
    // prefix()等はRouterクラスのメソッドであるが、where()はRouteクラスのメソッドであるという点で異なる
    foreach ($group->getRoutes() as $route) {
        $route->where('shop_id', '[0-9]+');
    }
});

/**
 * LIXIL管理画面
 * {domain}/admin/lixil/*
 */
Route::prefix('admin/lixil')->name('admin.lixil')->namespace('Mado\Admin\Lixil')->group(function () {
    // ログイン/ログアウト
    Route::get('/login', ['as' => '.login', 'uses' => 'LoginController@showLoginForm']);
    Route::post('/login', ['as' => '.auth', 'uses' => 'LoginController@login']);
    Route::post('/logout', ['as' => '.logout', 'uses' => 'LoginController@logout']);
});

Route::middleware('auth', 'can:lixil')->prefix('admin/lixil')->name('admin.lixil')->namespace('Mado\Admin\Lixil')->group(function () {

    // 管理画面TOP
    Route::get('/', ['as' => '', 'uses' => 'IndexController@index']);


    /**
     * 加盟店管理
     */
    Route::prefix('/shop')->name('.shop')->group(function () {

        // 加盟店一覧
        Route::get('/', ['as' => '', 'uses' => 'ShopController@index']);

        // 加盟店検索 キーワード絞り込み
        Route::get('/search', ['as' => '.search', 'uses' => 'ShopController@search']);


        // 加盟店新規登録
        Route::match(['get', 'post'], '/new', ['as' => '.new', 'uses' => 'ShopController@new']);

        // 加盟店新規登録 別ウィンドウに緯度経度を出力する
        Route::get('/geocode', ['as' => '.geocode', 'uses' => 'ShopController@geocode']);

        // 加盟店新規登録確認
        Route::post('/confirm', ['as' => '.confirm', 'uses' => 'ShopController@confirm']);

        // 加盟店新規登録完了 DBにショップ情報を保存する
        Route::post('/complete', ['as' => '.complete', 'uses' => 'ShopController@complete']);


        Route::prefix('/{shop_id}')->group(function ($group) {
            Route::name('.edit')->group(function () {
                // 加盟店編集
                Route::match(['get', 'post'], '/edit', ['as' => '', 'uses' => 'ShopController@edit']);

                // 加盟店新規編集 別ウィンドウに緯度経度を出力する
                Route::get('/geocode', ['as' => '.geocode', 'uses' => 'ShopController@editGeocode']);

                // 加盟店編集確認
                Route::post('/confirm', ['as' => '.confirm', 'uses' => 'ShopController@editConfirm']);

                // 加盟店編集完了 DBにショップ情報を保存する
                Route::post('/complete', ['as' => '.complete', 'uses' => 'ShopController@editComplete']);
            });

            // 加盟店削除 DBの加盟店情報を論理削除する
            Route::post('/delete', ['as' => '.delete', 'uses' => 'ShopController@delete']);

            // where()はメソッドチェーンできないため、ルートを定義してから再度取得し、各ルートのwhere()を呼び出す
            // prefix()等はRouterクラスのメソッドであるが、where()はRouteクラスのメソッドであるという点で異なる
            foreach ($group->getRoutes() as $route) {
                $route->where('shop_id', '[0-9]+');
            }

        });


    });

});

/**
 * スタティックオートロード
 * page/※/※
 */
Route::prefix('page')->name('page')->namespace('Mado\Page')->group(function () {

    // スタティックオートロードページ1階層
    Route::get('/{end_name}', ['as' => 'one_depth', 'uses' => 'PageAutoLoadController@one_depth']);
    // スタティックオートロードページ2階層
    Route::get('/{path1}/{end_name}', ['as' => 'two_depth', 'uses' => 'PageAutoLoadController@two_depth']);

});

Route::get('/checkdata-selling-code', ['as' => '.checkdata', 'uses' => 'CheckDataController@index']);
Route::get('/koiprice', ['as' => '.test', 'uses' => 'TesttController@index']);
Route::get('/koipricedownloaddata', ['as' => '.test', 'uses' => 'TesttController@download']);
Route::get('/test-import', ['as' => '.testimport', 'uses' => 'TesttController@index']);

Route::namespace('Tostem\Admin')->group(function () {
     
     Route::get('/koigentabledataupdategiesta', ['as' => '.koigentabledataupdategiesta', 'uses' => 'CommonController@genTableContentUpdataGiesta']);
     Route::get('/koiupdatedatapricegiesta', ['as' => '.koiupdatedatapricegiesta', 'uses' => 'CommonController@updateDataGiesta']);
     
});