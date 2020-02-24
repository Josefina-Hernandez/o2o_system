<?php

namespace App\Http\Controllers\Mado\Admin\Lixil;

use App\Facades\MadoLog;
use App\Http\Controllers\Controller;
use App\Http\Requests\Mado\Admin\Lixil\ShopRequest;
use App\Mail\AdminShopCreate;
use App\Mail\ShopInFirstEdit;
use App\Models\{
    Shop,
    User
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{
    Mail,
    Session,
    Storage,
	DB
};

class ShopController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index(Request $request)
    {
        // すべてのショップを読み込む
        $shops = Shop::newly()->paginate(20);

        return view(
            'mado.admin.lixil.shop.index',
            [
                'shops' => $shops,
            ]
        );
    }

    public function search(Request $request)
    {
        // 加盟店検索: 条件に応じたショップを読み込む
        $shops = Shop::searchAdminShop($request->query())->newly()->paginate(20);
        
        return view(
            'mado.admin.lixil.shop.index',
            [
                'shops' => $shops,
                'queryParams' => $request->query(),
            ]
        );
    }

    public function new(Request $request)
    {
        // 新規インスタンスを渡す
        $shop = new Shop();

        // 確認画面から戻ってきた際にリクエストの値を取得する
        if ($request->isMethod('post')) {
            $shop->fill($request->all());
        }

        /**
         * メイン画像の取得
         */
        // CSRFトークンを取得し、キャッシュのキーの一部に用いる
        $token = Session::token();
        if ($request->isMethod('get') && $request->session()->get('errors') === null) {
            // 通常アクセスの際、キャッシュに画像が残っていれば削除する
            $sizeNames = array_keys(config('const.common.image.MAX_LENGTHS'));
            foreach ($sizeNames as $sizeName) {
                app()->make('image_edit')->cacheDelete($token . 'main_' . $sizeName);
            }
            $mainPicture = null;

        } else {
            // バリデーションエラーや確認画面からの遷移の際は、キャッシュからメイン画像を取得する
            $mainPicture = app()->make('image_get')->cacheToBase64($token . 'main_l');
        }

        // バリデーションエラー時や、確認画面から戻ってきた際は前もって市区町村のリストを取得しておく
        if (old(config('const.db.shops.PREF_ID'))
            || $shop->{config('const.db.shops.PREF_ID')} !== null) {
            $cities = app()->make('get_list')->getCityList(old(config('const.db.shops.PREF_ID')) ? old(config('const.db.shops.PREF_ID')) : $shop->{config('const.db.shops.PREF_ID')});

        } else {
            $cities = null;
        }

        return view('mado.admin.lixil.shop.edit', [
            'shop' => $shop,
            'prefs' => app()->make('get_list')->getPrefList(),
            'cities' => $cities,
            'mainPicture' => $mainPicture,
        ]);
    }
    /**
     * 住所より緯度経度を表示させる
     */
    public function geocode(Request $request)
    {
        //緯度
        $lat=0;
        //経度
        $lng=0;

        $latlng = app()->make('geocode')->convertAddressToLatLng($request->address);
        
        if($latlng["status"]=="OK"){
            $lat = $latlng['results'][0]['geometry']['location']['lat'];
            $lng = $latlng['results'][0]['geometry']['location']['lng'];
        }

        return view(
            'mado.admin.lixil.shop.geocode',
            [
                "address" => $request->address,
                "lat" => $lat,
                "lng" => $lng,
            ]
        );
    }

    public function confirm(ShopRequest $request)
    {
        // 入力データをShopに格納する
        $shop = new Shop;
        $shop->fill($request->all());

        /**
         * 新規に選択された画像があればキャッシュに保存する
         */
        $image = $request->file(config('const.form.admin.lixil.shop.MAIN_PICTURE'));
        if ($image !== null) {
            // 新規選択画像をキャッシュする
            app()->make('image_edit')->setImage($image)->multipleCache($request->_token . 'main');
        }

        /**
         * 画像をキャッシュから取得する
         */
        $mainPicture = app()->make('image_get')->cacheToBase64($request->_token . 'main_l');

        return view('mado.admin.lixil.shop.confirm', [
            'shop' => $shop,
            'mainPicture' => $mainPicture,
        ]);
    }

    public function complete(ShopRequest $request)
    {
        // 入力データをShopに格納する
        try {
            $shop = Shop::create($request->all());
            MadoLog::info('Ls001 加盟店新規登録処理中、Shopの作成に完了しました。');
        } catch (\Exception $e) {
            MadoLog::error('Lf001 加盟店新規登録処理中、Shopの作成に失敗しました。', ['error' => $e->getMessage()]);
            throw $e;
        }

        // ショップIDが決定される
        $shopId = $shop->{config('const.db.shops.ID')};

        // ショップディレクトリを作成する
        Storage::makeDirectory("public/shop/{$shopId}");

        // メイン写真が選択されている場合、ショップディレクトリに移動する
        $sizeNames = array_keys(config('const.common.image.MAX_LENGTHS'));
        foreach ($sizeNames as $sizeName) {
            // メイン画像を保存する
            app()->make('image_edit')->cacheToStorage($request->_token . 'main_' . $sizeName, "shop/{$shopId}", "main_{$sizeName}");
        }

        // ログインユーザを発行する
        $newLoginId = app()->make('user_id_and_password')->createId();
        $newLoginPassword = app()->make('user_id_and_password')->createPassword();
        $encryptedPassword = app()->make('cipher')->encrypt($newLoginPassword);
        $shopClassId = $shop->shopClass->{config('const.db.shop_classes.ID')};
        try {
            $user = User::create([
                config('const.db.users.LOGIN_ID') => $newLoginId,
                config('const.db.users.PASSWORD') => $encryptedPassword,
                config('const.db.users.SHOP_ID') => $shopId,
                config('const.db.users.SHOP_CLASS_ID') => $shopClassId,
            ]);
            MadoLog::info('Ls002 加盟店新規登録処理中、Userの作成に完了しました。');
        } catch (\Exception $e) {
            MadoLog::error('Lf002 加盟店新規登録処理中、Userの作成に失敗しました。', ['error' => $e->getMessage()]);
            throw $e;
        }
        
        // issue#76: メール送信が不要になったためコメントアウト
        // メール送信: 加盟店とLIXIL
        // try {
        //     Mail::to($shop->{config('const.db.shops.EMAIL')})
        //         ->queue(new AdminShopCreate($shop));
        //     MadoLog::info('Ls014 加盟店新規登録処理中、加盟店へのメールのキューイングを完了しました。', ['to' => $shop->{config('const.db.shops.EMAIL')}]);
        // } catch (\Exception $e) {
        //     MadoLog::error('Lf014 加盟店新規登録処理中、加盟店へのメールのキューイングを失敗しました。', ['error' => $e->getMessage()]);
        //     throw $e;
        // }
        // sleep(0.5);
        // try {
        //     Mail::to(config('mail.from.address'))
        //         ->queue(new AdminShopCreate($shop));
        //     MadoLog::info('Ls015 加盟店新規登録処理中、LIXILへのメールのキューイングを完了しました。', ['to' => config('mail.from.address')]);
        // } catch (\Exception $e) {
        //     MadoLog::error('Lf015 加盟店新規登録処理中、LIXILへのメールのキューイングを失敗しました。', ['to' => config('mail.from.address'), 'error' => $e->getMessage()]);
        //     throw $e;
        // }

        // トークンをリフレッシュする
        $request->session()->regenerateToken();

        return view('mado.admin.lixil.shop.complete', [
            'shop' => $shop,
            'user' => $user,
        ]);
    }

    public function edit(Request $request, $shop_id)
    {
        // ショップを取得する
        $shop = Shop::find($shop_id);

        // 確認画面から戻ってきた際にリクエストの値を取得する
        if ($request->isMethod('post')) {
            $shop->fill($request->all());
        }

        /**
         * 画像の取得
         */
        // CSRFトークンを取得し、キャッシュのキーの一部に用いる
        $token = Session::token();
        if ($request->isMethod('get') && $request->session()->get('errors') === null) {
            // 通常アクセスの際、キャッシュに画像が残っていれば削除する
            $sizeNames = array_keys(config('const.common.image.MAX_LENGTHS'));
            foreach ($sizeNames as $sizeName) {
                app()->make('image_edit')->cacheDelete($token . 'main_' . $sizeName);
            }

            // ストレージからメイン画像を取得する
            $mainPicture = app()->make('image_get')->shopMainUrl($shop_id, 'l', false);

        } else {
            // バリデーションエラーや確認画面からの遷移の際は、キャッシュかストレージからメイン画像を取得する
            $mainPicture = app()->make('image_get')->cacheToBase64($token . 'main_l') ?: app()->make('image_get')->shopMainUrl($shop_id, 'l');
        }

        // バリデーションエラー時や、確認画面から戻ってきた際は前もって市区町村のリストを取得しておく
        if (old(config('const.db.shops.CITY_ID'))
            || $shop->{config('const.db.shops.CITY_ID')} !== null) {
            $cities = app()->make('get_list')->getCityList(old(config('const.db.shops.PREF_ID')) ? old(config('const.db.shops.PREF_ID')) : $shop->{config('const.db.shops.PREF_ID')});

        } else {
            $cities = null;
        }

        return view('mado.admin.lixil.shop.edit', [
            'shop' => $shop,
            'prefs' => app()->make('get_list')->getPrefList(),
            'cities' => $cities,
            'mainPicture' => $mainPicture,
        ]);
    }

    public function editGeocode(Request $request)
    {
        return view('mado.admin.lixil.shop.geocode');
    }

    public function editConfirm(ShopRequest $request, $shop_id)
    {
        // Shopを取得し、入力データを格納する
        $shop = Shop::find($shop_id)->fill($request->all());
        /**
         * 新規に選択された画像があればキャッシュに保存する
         */
        $image = $request->file(config('const.form.admin.lixil.shop.MAIN_PICTURE'));
        if ($image !== null) {
            // 新規選択画像をキャッシュする
            app()->make('image_edit')->setImage($image)->multipleCache($request->_token . 'main');
        }

        /**
         * 画像をキャッシュかストレージから取得する
         */
        $mainPicture = app()->make('image_get')->cacheToBase64($request->_token . 'main_l') ?: app()->make('image_get')->shopMainUrl($shop_id, 'l');
        // Add Start BP_MMEN-23 generate URL
       /* $data = $request->all();*/
        $first_time_edit = $shop->isFirstTimeEdit();
        /*if (isset($data[config('const.db.shops.SHOP_TYPE')]) == false) {
            $shop->{config('const.db.shops.SHOP_TYPE')} = null;
        }*/
        // Add End BP_MMEN-23 generate URL
        return view('mado.admin.lixil.shop.confirm', [
            'shop' => $shop,
            'mainPicture' => $mainPicture,
            'first_time_edit' => $first_time_edit, // Add BP_MMEN-23 generate URL
        ]);
    }

    public function editComplete(ShopRequest $request, $shop_id)
    {
        // Shopを取得し、入力データを格納する
        $shop = Shop::find($shop_id)->fill($request->all());
        try {
            $shop->save();
            MadoLog::info('Ls003 加盟店編集処理中、Shopの更新に完了しました。');
        } catch (\Exception $e) {
            MadoLog::error('Lf003 加盟店編集処理中、Shopの更新に失敗しました。', ['error' => $e->getMessage()]);
            throw $e;
        }

        /**
         * 新規に選択された画像をショップ配下の事例ディレクトリに移動する
         */
        $sizeNames = array_keys(config('const.common.image.MAX_LENGTHS'));
        foreach ($sizeNames as $sizeName) {
            // メイン画像を保存する
            app()->make('image_edit')->cacheToStorage($request->_token . 'main_' . $sizeName, "shop/{$shop_id}", "main_{$sizeName}");
        }

        // ログインユーザのショップ区分を更新する
        $user = $shop->user;
        $user->{config('const.db.users.SHOP_CLASS_ID')} = $shop->shopClass->{config('const.db.shop_classes.ID')};
        try {
            $user->save();
            MadoLog::info('Ls004 加盟店編集処理中、Userの更新に完了しました。');
        } catch (\Exception $e) {
            MadoLog::error('Lf004 加盟店編集処理中、Userの更新に失敗しました。', ['error' => $e->getMessage()]);
            throw $e;
        }

        //Add start Thanh Estimate 20191204
        $isFirstTimeEdit = $shop->isFirstTimeEdit(); // add Thanh Estimate 20191125
        if ($isFirstTimeEdit == true) {
            try {
                Mail::to($shop->email)
                    ->queue(new ShopInFirstEdit($request->all(), $shop));
                DB::table('t_generate_shop_history')->where('shop_id', $shop->id)->update(['frontend_url_publish' => 1]);
            } catch (\Exception $e) {
                MadoLog::info('EDIT SHOP: '. $e->getMessage());
                throw $e;
            }
        }
        //Add end Thanh Estimate 20191204
        // トークンをリフレッシュする
        $request->session()->regenerateToken();

        return view('mado.admin.lixil.shop.complete', [
            'shop' => $shop,
        ]);
    }

    public function delete(Request $request, $shop_id)
    {
        // ショップの取得
        $shop = Shop::find($shop_id);
        if ($shop !== null) {
            try {
                // プレミアム事例の削除
                $shop->premiumPhotos()->delete();
                MadoLog::info('Ls005 加盟店削除処理中、PremiumPhotoの削除に完了しました。');
            } catch (\Exception $e) {
                MadoLog::error('Lf005 加盟店削除処理中、PremiumPhotoの削除に失敗しました。', ['error' => $e->getMessage()]);
                throw $e;
            }

            try {
                // スタンダード事例の削除
                $shop->standardPhotos()->delete();
                MadoLog::info('Ls006 加盟店削除処理中、StandardPhotoの削除に完了しました。');
            } catch (\Exception $e) {
                MadoLog::error('Lf006 加盟店削除処理中、StandardPhotoの削除に失敗しました。', ['error' => $e->getMessage()]);
                throw $e;
            }

            try {
                // プレミアム記事の削除
                MadoLog::info('Ls007 加盟店削除処理中、PremiumArticleの削除に完了しました。');
            } catch (\Exception $e) {
                MadoLog::error('Lf007 加盟店削除処理中、PremiumArticleの削除に失敗しました。', ['error' => $e->getMessage()]);
                throw $e;
            }

            try {
                // スタンダード記事の削除
                MadoLog::info('Ls008 加盟店削除処理中、StandardArticleの削除に完了しました。');
            } catch (\Exception $e) {
                MadoLog::error('Lf008 加盟店削除処理中、StandardArticleの削除に失敗しました。', ['error' => $e->getMessage()]);
                throw $e;
            }

            try {
                // スタッフの削除
                $shop->staffs()->delete();
                MadoLog::info('Ls009 加盟店削除処理中、Staffの削除に完了しました。');
            } catch (\Exception $e) {
                MadoLog::error('Lf009 加盟店削除処理中、Staffの削除に失敗しました。', ['error' => $e->getMessage()]);
                throw $e;
            }

            try {
                // スタンダードお知らせの削除
                $shop->standardNotices()->delete();
                MadoLog::info('Ls010 加盟店削除処理中、StandardNoticeの削除に完了しました。');
            } catch (\Exception $e) {
                MadoLog::error('Lf010 加盟店削除処理中、StandardNoticeの削除に失敗しました。', ['error' => $e->getMessage()]);
                throw $e;
            }

            try {
                // 緊急メッセージの削除
                $shop->emergencyMessage()->delete();
                MadoLog::info('Ls011 加盟店削除処理中、EmergencyMessageの削除に完了しました。');
            } catch (\Exception $e) {
                MadoLog::error('Lf011 加盟店削除処理中、EmergencyMessageの削除に失敗しました。', ['error' => $e->getMessage()]);
                throw $e;
            }

            try {
                // ユーザの削除
                $shop->user()->delete();
                MadoLog::info('Ls012 加盟店削除処理中、Userの削除に完了しました。');
            } catch (\Exception $e) {
                MadoLog::error('Lf012 加盟店削除処理中、Userの削除に失敗しました。', ['error' => $e->getMessage()]);
                throw $e;
            }

            //Add Start Thanh Estimate 20191204
            try {
                // ユーザの削除
                $generate_shop_model = $shop->generate_shop_history();
                if ($generate_shop_model != null) {
                    $shop->generate_shop_history()->delete();
                }
                MadoLog::info('Ls013 加盟店削除処理中、Userの削除に完了しました。');
            } catch (\Exception $e) {
                MadoLog::error('Lf013 加盟店削除処理中、Userの削除に失敗しました。', ['error' => $e->getMessage()]);
                throw $e;
            }
            //Add End Thanh Estimate 20191204
            try {
                // ショップの削除
                $shop->delete();
                MadoLog::info('Ls014 加盟店削除処理中、Shopの削除に完了しました。');
            } catch (\Exception $e) {
                MadoLog::error('Lf014 加盟店削除処理中、Shopの削除に失敗しました。', ['error' => $e->getMessage()]);
                throw $e;
            }
        }

        return redirect()->route('admin.lixil.shop');
    }
}
