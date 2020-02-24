<?php

namespace App\Http\Controllers\Mado\Admin\Shop;

use App\Facades\{
    MadoLog,
    NoticeMessage
};
use App\Http\Controllers\Controller;
use App\Http\Requests\Mado\Admin\Shop\BannerRequest;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index(Request $request, $shop_id)
    {
        /**
         * バナーを取得する
         */
        $banners = collect();
        foreach (range(1, 5) as $rank) {
            $banner = Banner::shopId($shop_id)->rank($rank)->first();

            // 取得時にレコードが存在しなければ作成する
            if ($banner === null) {
                try {
                    // ログコードの決定
                    switch ($rank) {
                        case 1:
                            $logCode = '021';
                            break;

                        case 2:
                            $logCode = '022';
                            break;

                        case 3:
                            $logCode = '023';
                            break;

                        case 4:
                            $logCode = '024';
                            break;

                        case 5:
                            $logCode = '025';
                            break;
                    }

                    $banner = Banner::create([
                        config('const.db.banners.SHOP_ID') => $shop_id,
                        config('const.db.banners.RANK') => $rank,
                    ]);
                    MadoLog::info("Ss{$logCode} バナー編集処理中、Banner{$rank}の作成に完了しました。");
                } catch (\Exception $e) {
                    MadoLog::error("Sf{$logCode} バナー編集処理中、Banner{$rank}の作成に失敗しました。", ['error' => $e->getMessage()]);
                    throw $e;
                }

            }

            $banners->push($banner);
        }

        return view('mado.admin.shop.banner.index', [
            'banners' => $banners,
        ]);
    }

    public function edit(BannerRequest $request, $shop_id)
    {
        $data = $request->all();

        foreach (range(1, 5) as $rank) {
            // バナーの取得
            $banner = Banner::shopId($shop_id)->rank($rank)->first();

            /**
             * URLが入力されていれば有効なバナー: 入力値をDBに格納し、画像をアップロードする。
             * URLが入力されていれば無効なバナー: DBの格納データを初期化し、画像を削除する。
             */
            $url = array_get($data, config('const.db.banners.URL') . '_' . $rank, null);
            if ($url === null) {
                // URLが空欄であればこのバナーの情報を初期化する
                // 新規にインスタンスを作成し、初期値として利用する
                $newBanner = new Banner();
                $banner->fill([
                    config('const.db.banners.URL') => $newBanner->{config('const.db.banners.URL')},
                ]);
                try {
                    $banner->save();
                    MadoLog::info('Ss026 バナー編集処理中、Bannerの初期化に完了しました。');
                } catch (\Exception $e) {
                    MadoLog::error('Sf026 バナー編集処理中、Bannerの初期化に失敗しました。', ['error' => $e->getMessage()]);
                    throw $e;
                }

                // 画像を削除する
                app()->make('image_edit')->delete("shop/{$shop_id}/banner", "banner_{$rank}");

            } else {
                // URL入力されているため、バナー情報の更新を行う。

                // リクエストから入力値を取得する
                $input = collect($data)
                    ->filter(function ($value, $key) use ($rank) {
                        // _{$rank} で終わるnameのキーを抽出
                        // 例: url_3
                        return ends_with($key, "_{$rank}");
                    })->mapWithKeys(function ($value, $key) use ($rank) {
                        // キーから_{$rank}を消去する
                        // 例: url_3 を url に変換
                        return [str_before($key, "_{$rank}") => $value];
                    })->toArray();
                $banner->fill($input);
                try {
                    $banner->save();
                    MadoLog::info('Ss027 バナー編集処理中、Bannerの更新に完了しました。');
                } catch (\Exception $e) {
                    MadoLog::error('Sf027 バナー編集処理中、Bannerの更新に失敗しました。', ['error' => $e->getMessage()]);
                    throw $e;
                }

                // 画像をリクエストから取得する
                $picture = $request->file(config('const.form.admin.shop.banner.PICTURE') . '_' . $rank);
                if ($picture !== null) {
                    // 新規選択画像をストレージに保存する
                    app()->make('image_edit')->setImage($picture)->encode('jpg',  config('const.common.image.ENCODE_QUALITY'))->save("shop/{$shop_id}/banner", "banner_{$rank}");
                }
            }
        }

        // 通知メッセージの登録
        NoticeMessage::adminShopBanner();

        return redirect()->route('admin.shop.banner', ['shop_id' => $shop_id]);
    }
}
