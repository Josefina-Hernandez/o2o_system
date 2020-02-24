<?php

namespace App\Http\Controllers\Mado\Admin\Shop;

use App\Facades\MadoLog;
use App\Http\Controllers\Controller;
use App\Http\Requests\Mado\Admin\Shop\ShopRequest;
use App\Models\GenerateShopHistory;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\ShopInFirstEdit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class ShopController extends Controller
{
    public function __construct()
    {
        //
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

        return view('mado.admin.shop.edit', [
            'shop' => $shop,
            'prefs' => app()->make('get_list')->getPrefList(),
            'cities' => $cities,
            'mainPicture' => $mainPicture,
        ]);
    }

    public function confirm(ShopRequest $request, $shop_id)
    {
        // Shopを取得し、入力データを格納する
        $shop = Shop::find($shop_id)->fill($request->all());

        /**
         * 新規に選択された画像があればキャッシュに保存する
         */
        $image = $request->file(config('const.form.admin.shop.MAIN_PICTURE'));
        if ($image !== null) {
            // 新規選択画像をキャッシュする
            app()->make('image_edit')->setImage($image)->multipleCache($request->_token . 'main');
        }
        
        /**
         * 画像をキャッシュかストレージから取得する
         */
        $mainPicture = app()->make('image_get')->cacheToBase64($request->_token . 'main_l') ?: app()->make('image_get')->shopMainUrl($shop_id, 'l');

        $data_user = array();

        $data_user[config('const.db.users.PASSWORD')] = $request->password;
        $data_user['password_new'] = $request->password_new;
        $data_user['password_confirm'] = $request->password_confirm;


        $first_time_edit = $shop->isFirstTimeEdit(); // Add BP_MMEN-23 generate URL
        /*$data = $request->all();
        if (isset($data[config('const.db.shops.SHOP_TYPE')]) == false) {
            $shop->{config('const.db.shops.SHOP_TYPE')} = null;
        }*/
        return view('mado.admin.shop.confirm', [
            'shop' => $shop,
            'mainPicture' => $mainPicture,
            'data_user' => $data_user,
            'first_time_edit' => $first_time_edit, // Add BP_MMEN-23 generate URL
        ]);
    }

    public function complete(ShopRequest $request, $shop_id)
    {
        // Shopを取得し、入力データを格納する
        $shop = Shop::find($shop_id)->fill($request->all());
        try {
            $shop->save();
            MadoLog::info('Ss001 会社情報編集処理中、Shopの更新に完了しました。');
        } catch (\Exception $e) {
            MadoLog::error('Sf001 会社情報編集処理中、Shopの更新に失敗しました。', ['error' => $e->getMessage()]);
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

        //Add start Thanh Estimate 20191125
        if (\HelpersCart::is_general_site() && $request->has('password_new') && $request->password_new !== null) {
            $user = User::find(Auth::user()->{config('const.db.users.ID')});
            $user->{config('const.db.users.PASSWORD')} = \Hash::make($request->password_new);
            try {
                $user->save();
            } catch (\Exception $e) {
                throw $e;
            }
        }
        //Add end Thanh Estimate 20191125
        //Add start Thanh Estimate 20191204
        $isFirstTimeEdit = $shop->isFirstTimeEdit(); // add Thanh Estimate 20191125
        if ($isFirstTimeEdit == true) {
            try {
                Mail::to($shop->email)
                    ->queue(new ShopInFirstEdit($request->all(), $shop));

                $generate_relation = $shop->generate_shop_history();
                $GenerateShopHistory = $generate_relation->first();
                if ($GenerateShopHistory != null) {
                    $GenerateShopHistory->{config('const.db.t_generate_shop_history.FRONTEND_URL_PUBLISH')} = 1;
                    $GenerateShopHistory->{config('const.db.t_generate_shop_history.FRONTEND_URL_MAIL_CONTENT')}
                        = view('mado.mail.shop_info', ['shop' => $shop]);
                    $GenerateShopHistory->save();
                }

            } catch (\Exception $e) {
                throw $e;
            }
        }
        //Add end Thanh Estimate 20191204

        // トークンをリフレッシュする
        $request->session()->regenerateToken();

        return redirect()->route('admin.shop', ['shop_id' => $shop_id]);
    }
}
