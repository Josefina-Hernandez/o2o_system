<?php

namespace App\Http\Controllers\Mado\Admin\Shop;

use App\Facades\{
    MadoLog,
    NoticeMessage
};
use App\Http\Controllers\Controller;
use App\Http\Requests\Mado\Admin\Shop\PhotoRequest;
use App\Models\{
    Shop,
    StandardPhoto
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class PhotoController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index(Request $request, $shop_id)
    {
        // ショップを取得する
        $shop = Shop::find($shop_id);

        // ショップに紐付いたスタンダード事例を取得する
        // 登録日を降順とする
        $standardPhotos = StandardPhoto::shopId($shop_id)->orderByDesc(config('const.db.standard_photos.CREATED_AT'))->paginate(20);

        return view('mado.admin.shop.photo.index', [
            'shop' => $shop,
            'standardPhotos' => $standardPhotos,
        ]);
    }

    public function new(Request $request, $shop_id)
    {
        // 新規インスタンスを渡す
        $standardPhoto = new StandardPhoto([config('const.db.standard_photos.SHOP_ID') => $shop_id]);
        
        // 確認画面から戻ってきた際にリクエストの値を取得する
        if ($request->isMethod('post')) {
            $standardPhoto->fill($request->all());
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
            app()->make('image_edit')->cacheDelete($token . 'photo_before');
            app()->make('image_edit')->cacheDelete($token . 'photo_before_2');
            app()->make('image_edit')->cacheDelete($token . 'photo_before_3');
            app()->make('image_edit')->cacheDelete($token . 'photo_after');
            app()->make('image_edit')->cacheDelete($token . 'photo_after_2');
            app()->make('image_edit')->cacheDelete($token . 'photo_after_3');
            app()->make('image_edit')->cacheDelete($token . 'photo_customer');
            app()->make('image_edit')->cacheDelete($token . 'photo_customer_2');

            $mainPicture = null;
            $beforePicture = null;
            $beforePicture2 = null;
            $beforePicture3 = null;
            $afterPicture = null;
            $afterPicture2 = null;
            $afterPicture3 = null;
            $customerPicture = null;
            $customerPicture2 = null;

        } else {
            // バリデーションエラーや確認画面からの遷移の際は、キャッシュから画像を取得する
            $mainPicture = app()->make('image_get')->cacheToBase64($token . 'photo_main_l');
            $beforePicture = app()->make('image_get')->cacheToBase64($token . 'photo_before');
            $beforePicture2 = app()->make('image_get')->cacheToBase64($token . 'photo_before_2');
            $beforePicture3 = app()->make('image_get')->cacheToBase64($token . 'photo_before_3');
            $afterPicture = app()->make('image_get')->cacheToBase64($token . 'photo_after');
            $afterPicture2 = app()->make('image_get')->cacheToBase64($token . 'photo_after_2');
            $afterPicture3 = app()->make('image_get')->cacheToBase64($token . 'photo_after_3');
            $customerPicture = app()->make('image_get')->cacheToBase64($token . 'photo_customer');
            $customerPicture2 = app()->make('image_get')->cacheToBase64($token . 'photo_customer_2');
        }

        return view('mado.admin.shop.photo.edit', [
            'standardPhoto' => $standardPhoto,
            'mainPicture' => $mainPicture,
            'beforePicture' => $beforePicture,
            'beforePicture2' => $beforePicture2,
            'beforePicture3' => $beforePicture3,
            'afterPicture' => $afterPicture,
            'afterPicture2' => $afterPicture2,
            'afterPicture3' => $afterPicture3,
            'customerPicture' => $customerPicture,
            'customerPicture2' => $customerPicture2,
        ]);
    }

    public function confirm(PhotoRequest $request, $shop_id)
    {
        // 入力データを格納する
        $standardPhoto = new StandardPhoto(['shop_id' => $shop_id]);
        $standardPhoto->fill($request->all());

        /**
         * 新規に選択された画像があればキャッシュに保存する
         */
        $mainPicture = $request->file(config('const.form.admin.shop.standard_photo.MAIN_PICTURE'));
        if ($mainPicture !== null) {
            // 新規選択画像をキャッシュする
            app()->make('image_edit')->setImage($mainPicture)->multipleCache($request->_token . 'photo_main');
        }
        $beforePicture = $request->file(config('const.form.admin.shop.standard_photo.BEFORE_PICTURE'));
        if ($beforePicture !== null) {
            // 新規選択画像をキャッシュする
            app()->make('image_edit')->setImage($beforePicture)->resizeTo('l')->encode('jpg',  config('const.common.image.ENCODE_QUALITY'))->cache($request->_token . 'photo_before');
        }
        $beforePicture2 = $request->file(config('const.form.admin.shop.standard_photo.BEFORE_PICTURE_2'));
        if ($beforePicture2 !== null) {
            // 新規選択画像をキャッシュする
            app()->make('image_edit')->setImage($beforePicture2)->resizeTo('l')->encode('jpg',  config('const.common.image.ENCODE_QUALITY'))->cache($request->_token . 'photo_before_2');
        }
        $beforePicture3 = $request->file(config('const.form.admin.shop.standard_photo.BEFORE_PICTURE_3'));
        if ($beforePicture3 !== null) {
            // 新規選択画像をキャッシュする
            app()->make('image_edit')->setImage($beforePicture3)->resizeTo('l')->encode('jpg',  config('const.common.image.ENCODE_QUALITY'))->cache($request->_token . 'photo_before_3');
        }
        $afterPicture = $request->file(config('const.form.admin.shop.standard_photo.AFTER_PICTURE'));
        if ($afterPicture !== null) {
            // 新規選択画像をキャッシュする
            app()->make('image_edit')->setImage($afterPicture)->resizeTo('l')->encode('jpg',  config('const.common.image.ENCODE_QUALITY'))->cache($request->_token . 'photo_after');
        }
        $afterPicture2 = $request->file(config('const.form.admin.shop.standard_photo.AFTER_PICTURE_2'));
        if ($afterPicture2 !== null) {
            // 新規選択画像をキャッシュする
            app()->make('image_edit')->setImage($afterPicture2)->resizeTo('l')->encode('jpg',  config('const.common.image.ENCODE_QUALITY'))->cache($request->_token . 'photo_after_2');
        }
        $afterPicture3 = $request->file(config('const.form.admin.shop.standard_photo.AFTER_PICTURE_3'));
        if ($afterPicture3 !== null) {
            // 新規選択画像をキャッシュする
            app()->make('image_edit')->setImage($afterPicture3)->resizeTo('l')->encode('jpg',  config('const.common.image.ENCODE_QUALITY'))->cache($request->_token . 'photo_after_3');
        }
        $customerPicture = $request->file(config('const.form.admin.shop.standard_photo.CUSTOMER_PICTURE'));
        if ($customerPicture !== null) {
            // 新規選択画像をキャッシュする
            app()->make('image_edit')->setImage($customerPicture)->resizeTo('l')->encode('jpg',  config('const.common.image.ENCODE_QUALITY'))->cache($request->_token . 'photo_customer');
        }
        $customerPicture2 = $request->file(config('const.form.admin.shop.standard_photo.CUSTOMER_PICTURE_2'));
        if ($customerPicture2 !== null) {
            // 新規選択画像をキャッシュする
            app()->make('image_edit')->setImage($customerPicture2)->encode('jpg',  config('const.common.image.ENCODE_QUALITY'))->cache($request->_token . 'photo_customer_2');
        }

        /**
         * 画像をキャッシュから取得する
         */
        $mainPicture = app()->make('image_get')->cacheToBase64($request->_token . 'photo_main_l');
        $beforePicture = app()->make('image_get')->cacheToBase64($request->_token . 'photo_before');
        $beforePicture2 = app()->make('image_get')->cacheToBase64($request->_token . 'photo_before_2');
        $beforePicture3 = app()->make('image_get')->cacheToBase64($request->_token . 'photo_before_3');
        $afterPicture = app()->make('image_get')->cacheToBase64($request->_token . 'photo_after');
        $afterPicture2 = app()->make('image_get')->cacheToBase64($request->_token . 'photo_after_2');
        $afterPicture3 = app()->make('image_get')->cacheToBase64($request->_token . 'photo_after_3');
        $customerPicture = app()->make('image_get')->cacheToBase64($request->_token . 'photo_customer');
        $customerPicture2 = app()->make('image_get')->cacheToBase64($request->_token . 'photo_customer_2');

        // 施工前画像と施工後画像を配列に格納する
        $beforePictures = array_where([$beforePicture, $beforePicture2, $beforePicture3], function ($value, $key) {
            return $value !== null;
        });
        $afterPictures = array_where([$afterPicture, $afterPicture2, $afterPicture3], function ($value, $key) {
            return $value !== null;
        });

        /**
         * 通知メッセージを登録する
         */
        NoticeMessage::adminShopPhotoConfirm();

        return view('mado.admin.shop.photo.confirm', [
            'standardPhoto' => $standardPhoto,
            'mainPicture' => $mainPicture,
            'beforePictures' => $beforePictures,
            'afterPictures' => $afterPictures,
            'customerPicture' => $customerPicture,
            'customerPicture2' => $customerPicture2,
        ]);
    }

    public function complete(PhotoRequest $request, $shop_id)
    {
        try {
            // StandardPhotoを取得し、入力データを格納する
            $standardPhoto = StandardPhoto::create($request->all());
            MadoLog::info('Ss009 スタンダード施工事例新規登録処理中、StandardPhotoの作成に完了しました。');
        } catch (\Exception $e) {
            MadoLog::error('Sf009 スタンダード施工事例新規登録処理中、StandardPhotoの作成に失敗しました。', ['error' => $e->getMessage()]);
            throw $e;
        }
        $photoId = $standardPhoto->{config('const.db.standard_photos.ID')};

        /**
         * 各画像をショップディレクトリに移動する
         */
        $sizeNames = array_keys(config('const.common.image.MAX_LENGTHS'));
        foreach ($sizeNames as $sizeName) {
            // メイン画像を保存する
            app()->make('image_edit')->cacheToStorage($request->_token . 'photo_main_' . $sizeName, "shop/{$shop_id}/photo/{$photoId}", "main_{$sizeName}");
        }
        // 施工前画像を保存する
        app()->make('image_edit')->cacheToStorage($request->_token . 'photo_before', "shop/{$shop_id}/photo/{$photoId}", 'before');
        app()->make('image_edit')->cacheToStorage($request->_token . 'photo_before_2', "shop/{$shop_id}/photo/{$photoId}", 'before_2');
        app()->make('image_edit')->cacheToStorage($request->_token . 'photo_before_3', "shop/{$shop_id}/photo/{$photoId}", 'before_3');
        // 施工後画像を保存する
        app()->make('image_edit')->cacheToStorage($request->_token . 'photo_after', "shop/{$shop_id}/photo/{$photoId}", 'after');
        app()->make('image_edit')->cacheToStorage($request->_token . 'photo_after_2', "shop/{$shop_id}/photo/{$photoId}", 'after_2');
        app()->make('image_edit')->cacheToStorage($request->_token . 'photo_after_3', "shop/{$shop_id}/photo/{$photoId}", 'after_3');
        // お客様の声画像を保存する
        app()->make('image_edit')->cacheToStorage($request->_token . 'photo_customer', "shop/{$shop_id}/photo/{$photoId}", 'customer');
        app()->make('image_edit')->cacheToStorage($request->_token . 'photo_customer_2', "shop/{$shop_id}/photo/{$photoId}", 'customer_2');

        // トークンをリフレッシュする
        $request->session()->regenerateToken();

        return redirect()->route('admin.shop.photo', ['shop_id' => $shop_id]);
    }

    public function edit(Request $request, $shop_id, $photo_id)
    {
        // 事例を取得する
        $standardPhoto = StandardPhoto::find($photo_id);

        // 確認画面から戻ってきた際にリクエストの値を取得する
        if ($request->isMethod('post')) {
            $standardPhoto->fill($request->all());
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
            app()->make('image_edit')->cacheDelete($token . 'photo_before');
            app()->make('image_edit')->cacheDelete($token . 'photo_before_2');
            app()->make('image_edit')->cacheDelete($token . 'photo_before_3');
            app()->make('image_edit')->cacheDelete($token . 'photo_after');
            app()->make('image_edit')->cacheDelete($token . 'photo_after_2');
            app()->make('image_edit')->cacheDelete($token . 'photo_after_3');
            app()->make('image_edit')->cacheDelete($token . 'photo_customer');
            app()->make('image_edit')->cacheDelete($token . 'photo_customer_2');

            // ストレージから画像を取得する
            $mainPicture = app()->make('image_get')->standardPhotoMainUrl($photo_id, 'l');
            $beforePicture = app()->make('image_get')->standardPhotoBeforeUrl($photo_id);
            $beforePicture2 = app()->make('image_get')->standardPhotoBefore2Url($photo_id);
            $beforePicture3 = app()->make('image_get')->standardPhotoBefore3Url($photo_id);
            $afterPicture = app()->make('image_get')->standardPhotoAfterUrl($photo_id);
            $afterPicture2 = app()->make('image_get')->standardPhotoAfter2Url($photo_id);
            $afterPicture3 = app()->make('image_get')->standardPhotoAfter3Url($photo_id);
            $customerPicture = app()->make('image_get')->standardPhotoCustomerUrl($photo_id);
            $customerPicture2 = app()->make('image_get')->standardPhotoCustomer2Url($photo_id);

        } else {
            // バリデーションエラーや確認画面からの遷移の際は、キャッシュから画像を取得する
            // キャッシュになかった場合はストレージから取得を試みる
            $mainPicture = app()->make('image_get')->cacheToBase64($token . 'photo_main_l') ?: app()->make('image_get')->standardPhotoMainUrl($photo_id, 'l');
            $beforePicture = app()->make('image_get')->cacheToBase64($token . 'photo_before') ?: app()->make('image_get')->standardPhotoBeforeUrl($photo_id);
            $beforePicture2 = app()->make('image_get')->cacheToBase64($token . 'photo_before_2') ?: app()->make('image_get')->standardPhotoBefore2Url($photo_id);
            $beforePicture3 = app()->make('image_get')->cacheToBase64($token . 'photo_before_3') ?: app()->make('image_get')->standardPhotoBefore3Url($photo_id);
            $afterPicture = app()->make('image_get')->cacheToBase64($token . 'photo_after') ?: app()->make('image_get')->standardPhotoAfterUrl($photo_id);
            $afterPicture2 = app()->make('image_get')->cacheToBase64($token . 'photo_after_2') ?: app()->make('image_get')->standardPhotoAfter2Url($photo_id);
            $afterPicture3 = app()->make('image_get')->cacheToBase64($token . 'photo_after_3') ?: app()->make('image_get')->standardPhotoAfter3Url($photo_id);
            $customerPicture = app()->make('image_get')->cacheToBase64($token . 'photo_customer') ?: app()->make('image_get')->standardPhotoCustomerUrl($photo_id);
            $customerPicture2 = app()->make('image_get')->cacheToBase64($token . 'photo_customer_2') ?: app()->make('image_get')->standardPhotoCustomer2Url($photo_id);
        }

        return view('mado.admin.shop.photo.edit', [
            'standardPhoto' => $standardPhoto,
            'mainPicture' => $mainPicture,
            'beforePicture' => $beforePicture,
            'beforePicture2' => $beforePicture2,
            'beforePicture3' => $beforePicture3,
            'afterPicture' => $afterPicture,
            'afterPicture2' => $afterPicture2,
            'afterPicture3' => $afterPicture3,
            'customerPicture' => $customerPicture,
            'customerPicture2' => $customerPicture2,
        ]);
    }

    public function editConfirm(PhotoRequest $request, $shop_id, $photo_id)
    {
        /**
         * 入力データを格納する
         */
        $standardPhoto = StandardPhoto::find($photo_id);
        $standardPhoto->fill($request->all());

        /**
         * 新規に選択された画像があればキャッシュに保存する
         */
        $mainPicture = $request->file(config('const.form.admin.shop.standard_photo.MAIN_PICTURE'));
        if ($mainPicture !== null) {
            // 新規選択画像をキャッシュする
            app()->make('image_edit')->setImage($mainPicture)->multipleCache($request->_token . 'photo_main');
        }
        $beforePicture = $request->file(config('const.form.admin.shop.standard_photo.BEFORE_PICTURE'));
        if ($beforePicture !== null) {
            // 新規選択画像をキャッシュする
            app()->make('image_edit')->setImage($beforePicture)->resizeTo('l')->encode('jpg',  config('const.common.image.ENCODE_QUALITY'))->cache($request->_token . 'photo_before');
        }
        $beforePicture2 = $request->file(config('const.form.admin.shop.standard_photo.BEFORE_PICTURE_2'));
        if ($beforePicture2 !== null) {
            // 新規選択画像をキャッシュする
            app()->make('image_edit')->setImage($beforePicture2)->resizeTo('l')->encode('jpg',  config('const.common.image.ENCODE_QUALITY'))->cache($request->_token . 'photo_before_2');
        }
        $beforePicture3 = $request->file(config('const.form.admin.shop.standard_photo.BEFORE_PICTURE_3'));
        if ($beforePicture3 !== null) {
            // 新規選択画像をキャッシュする
            app()->make('image_edit')->setImage($beforePicture3)->resizeTo('l')->encode('jpg',  config('const.common.image.ENCODE_QUALITY'))->cache($request->_token . 'photo_before_3');
        }
        $afterPicture = $request->file(config('const.form.admin.shop.standard_photo.AFTER_PICTURE'));
        if ($afterPicture !== null) {
            // 新規選択画像をキャッシュする
            app()->make('image_edit')->setImage($afterPicture)->resizeTo('l')->encode('jpg',  config('const.common.image.ENCODE_QUALITY'))->cache($request->_token . 'photo_after');
        }
        $afterPicture2 = $request->file(config('const.form.admin.shop.standard_photo.AFTER_PICTURE_2'));
        if ($afterPicture2 !== null) {
            // 新規選択画像をキャッシュする
            app()->make('image_edit')->setImage($afterPicture2)->resizeTo('l')->encode('jpg',  config('const.common.image.ENCODE_QUALITY'))->cache($request->_token . 'photo_after_2');
        }
        $afterPicture3 = $request->file(config('const.form.admin.shop.standard_photo.AFTER_PICTURE_3'));
        if ($afterPicture3 !== null) {
            // 新規選択画像をキャッシュする
            app()->make('image_edit')->setImage($afterPicture3)->resizeTo('l')->encode('jpg',  config('const.common.image.ENCODE_QUALITY'))->cache($request->_token . 'photo_after_3');
        }
        $customerPicture = $request->file(config('const.form.admin.shop.standard_photo.CUSTOMER_PICTURE'));
        if ($customerPicture !== null) {
            // 新規選択画像をキャッシュする
            app()->make('image_edit')->setImage($customerPicture)->resizeTo('l')->encode('jpg',  config('const.common.image.ENCODE_QUALITY'))->cache($request->_token . 'photo_customer');
        }
        $customerPicture2 = $request->file(config('const.form.admin.shop.standard_photo.CUSTOMER_PICTURE_2'));
        if ($customerPicture2 !== null) {
            // 新規選択画像をキャッシュする
            app()->make('image_edit')->setImage($customerPicture2)->encode('jpg',  config('const.common.image.ENCODE_QUALITY'))->cache($request->_token . 'photo_customer_2');
        }

        /**
         * 画像をキャッシュかストレージから取得する
         */
        $mainPicture = app()->make('image_get')->cacheToBase64($request->_token . 'photo_main_l') ?: app()->make('image_get')->standardPhotoMainUrl($photo_id, 'l');
        $beforePicture = app()->make('image_get')->cacheToBase64($request->_token . 'photo_before') ?: app()->make('image_get')->standardPhotoBeforeUrl($photo_id);
        $beforePicture2 = app()->make('image_get')->cacheToBase64($request->_token . 'photo_before_2') ?: app()->make('image_get')->standardPhotoBefore2Url($photo_id);
        $beforePicture3 = app()->make('image_get')->cacheToBase64($request->_token . 'photo_before_3') ?: app()->make('image_get')->standardPhotoBefore3Url($photo_id);
        $afterPicture = app()->make('image_get')->cacheToBase64($request->_token . 'photo_after') ?: app()->make('image_get')->standardPhotoAfterUrl($photo_id);
        $afterPicture2 = app()->make('image_get')->cacheToBase64($request->_token . 'photo_after_2') ?: app()->make('image_get')->standardPhotoAfter2Url($photo_id);
        $afterPicture3 = app()->make('image_get')->cacheToBase64($request->_token . 'photo_after_3') ?: app()->make('image_get')->standardPhotoAfter3Url($photo_id);
        $customerPicture = app()->make('image_get')->cacheToBase64($request->_token . 'photo_customer') ?: app()->make('image_get')->standardPhotoCustomerUrl($photo_id);
        $customerPicture2 = app()->make('image_get')->cacheToBase64($request->_token . 'photo_customer_2') ?: app()->make('image_get')->standardPhotoCustomer2Url($photo_id);

        // 施工前画像と施工後画像を配列に格納する
        $beforePictures = array_where([$beforePicture, $beforePicture2, $beforePicture3], function ($value, $key) {
            return $value !== null;
        });
        $afterPictures = array_where([$afterPicture, $afterPicture2, $afterPicture3], function ($value, $key) {
            return $value !== null;
        });

        /**
         * 通知メッセージを登録する
         */
        NoticeMessage::adminShopPhotoConfirm();

        return view('mado.admin.shop.photo.confirm', [
            'standardPhoto' => $standardPhoto,
            'mainPicture' => $mainPicture,
            'beforePictures' => $beforePictures,
            'afterPictures' => $afterPictures,
            'customerPicture' => $customerPicture,
            'customerPicture2' => $customerPicture2,
        ]);
    }

    public function editComplete(PhotoRequest $request, $shop_id, $photo_id)
    {
        // StandardPhotoを取得し、入力データを格納する
        $standardPhoto = StandardPhoto::find($photo_id)->fill($request->all());

        try {
            $standardPhoto->save();
            MadoLog::info('Ss010 スタンダード施工事例編集処理中、StandardPhotoの更新に完了しました。');
        } catch (\Exception $e) {
            MadoLog::error('Sf010 スタンダード施工事例編集処理中、StandardPhotoの更新に失敗しました。', ['error' => $e->getMessage()]);
            throw $e;
        }

        /**
         * 新規に選択された画像をショップ配下の事例ディレクトリに移動する
         */
        $sizeNames = array_keys(config('const.common.image.MAX_LENGTHS'));
        foreach ($sizeNames as $sizeName) {
            // メイン画像を保存する
            app()->make('image_edit')->cacheToStorage($request->_token . 'photo_main_' . $sizeName, "shop/{$shop_id}/photo/{$photo_id}", "main_{$sizeName}");
        }
        // 施工前画像を保存する
        app()->make('image_edit')->cacheToStorage($request->_token . 'photo_before', "shop/{$shop_id}/photo/{$photo_id}", 'before');
        app()->make('image_edit')->cacheToStorage($request->_token . 'photo_before_2', "shop/{$shop_id}/photo/{$photo_id}", 'before_2');
        app()->make('image_edit')->cacheToStorage($request->_token . 'photo_before_3', "shop/{$shop_id}/photo/{$photo_id}", 'before_3');
        // 施工後画像を保存する
        app()->make('image_edit')->cacheToStorage($request->_token . 'photo_after', "shop/{$shop_id}/photo/{$photo_id}", 'after');
        app()->make('image_edit')->cacheToStorage($request->_token . 'photo_after_2', "shop/{$shop_id}/photo/{$photo_id}", 'after_2');
        app()->make('image_edit')->cacheToStorage($request->_token . 'photo_after_3', "shop/{$shop_id}/photo/{$photo_id}", 'after_3');
        // お客様の声画像を保存する
        app()->make('image_edit')->cacheToStorage($request->_token . 'photo_customer', "shop/{$shop_id}/photo/{$photo_id}", 'customer');
        app()->make('image_edit')->cacheToStorage($request->_token . 'photo_customer_2', "shop/{$shop_id}/photo/{$photo_id}", 'customer_2');

        // トークンをリフレッシュする
        $request->session()->regenerateToken();

        return redirect()->route('admin.shop.photo', ['shop_id' => $shop_id]);
    }

    public function delete(Request $request, $shop_id, $photo_id)
    {
        $standardPhoto = StandardPhoto::find($photo_id);
        if ($standardPhoto !== null) {
            try {
                $standardPhoto->delete();
                MadoLog::info('Ss011 スタンダード施工事例削除処理中、StandardPhotoの削除に完了しました。');
            } catch (\Exception $e) {
                MadoLog::error('Sf011 スタンダード施工事例削除処理中、StandardPhotoの削除に失敗しました。', ['error' => $e->getMessage()]);
                throw $e;
            }
        }

        return redirect()->route('admin.shop.photo', ['shop_id' => $shop_id]);
    }

}
