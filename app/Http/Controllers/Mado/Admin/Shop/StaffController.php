<?php

namespace App\Http\Controllers\Mado\Admin\Shop;

use App\Facades\{
    MadoLog,
    NoticeMessage
};
use App\Http\Controllers\Controller;
use App\Http\Requests\Mado\Admin\Shop\StaffRequest;
use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index(Request $request, $shop_id)
    {
        /**
         * スタッフを取得する
         */
        $staffs = collect();
        foreach (range(1, 5) as $rank) {
            $staff = Staff::shopId($shop_id)->rank($rank)->first();

            // 取得時にレコードが存在しなければ作成する
            if ($staff === null) {
                try {
                    // ログコードの決定
                    switch ($rank) {
                        case 1:
                            $logCode = '002';
                            break;

                        case 2:
                            $logCode = '003';
                            break;

                        case 3:
                            $logCode = '004';
                            break;

                        case 4:
                            $logCode = '005';
                            break;

                        case 5:
                            $logCode = '006';
                            break;
                    }

                    $staff = Staff::create([
                        config('const.db.staffs.SHOP_ID') => $shop_id,
                        config('const.db.staffs.RANK') => $rank,
                    ]);
                    MadoLog::info("Ss{$logCode} スタッフ編集処理中、Staff{$rank}の作成に完了しました。");
                } catch (\Exception $e) {
                    MadoLog::error("Sf{$logCode} スタッフ編集処理中、Staff{$rank}の作成に失敗しました。", ['error' => $e->getMessage()]);
                    throw $e;
                }

            }

            $staffs->push($staff);
        }

        return view('mado.admin.shop.staff.index', [
            'staffs' => $staffs,
        ]);
    }

    public function edit(StaffRequest $request, $shop_id)
    {
        $data = $request->all();

        foreach (range(1, 5) as $rank) {
            // スタッフの取得
            $staff = Staff::shopId($shop_id)->rank($rank)->first();

            /**
             * 名前が入力されていれば有効なスタッフ: 入力値をDBに格納し、画像をアップロードする。
             * 名前が入力されていれば無効なスタッフ: DBの格納データを初期化し、画像を削除する。
             */
            $name = array_get($data, config('const.db.staffs.NAME') . '_' . $rank, null);
            if ($name === null) {
                // 名前が空欄であればこのスタッフの情報を初期化する
                // 新規にインスタンスを作成し、初期値として利用する
                $newStaff = new Staff();
                $staff->fill([
                    config('const.db.staffs.NAME') => $newStaff->{config('const.db.staffs.NAME')},
                    config('const.db.staffs.MESSAGE') => $newStaff->{config('const.db.staffs.MESSAGE')},
                    config('const.db.staffs.POST') => $newStaff->{config('const.db.staffs.POST')},
                ]);
                try {
                    $staff->save();
                    MadoLog::info('Ss007 スタッフ編集処理中、Staffの初期化に完了しました。');
                } catch (\Exception $e) {
                    MadoLog::error('Sf007 スタッフ編集処理中、Staffの初期化に失敗しました。', ['error' => $e->getMessage()]);
                    throw $e;
                }

                // 画像を削除する
                app()->make('image_edit')->delete("shop/{$shop_id}/staff", "staff_{$rank}");

            } else {
                // 名前が入力されているため、スタッフ情報の更新を行う。

                // リクエストから入力値を取得する
                $input = collect($data)
                    ->filter(function ($value, $key) use ($rank) {
                        // _{$rank} で終わるnameのキーを抽出
                        // 例: name_3, message_3
                        return ends_with($key, "_{$rank}");
                    })->mapWithKeys(function ($value, $key) use ($rank) {
                        // キーから_{$rank}を消去する
                        // 例: name_3, message_3 を name, message に変換
                        return [str_before($key, "_{$rank}") => $value];
                    })->toArray();
                $staff->fill($input);
                try {
                    $staff->save();
                    MadoLog::info('Ss008 スタッフ編集処理中、Staffの更新に完了しました。');
                } catch (\Exception $e) {
                    MadoLog::error('Sf008 スタッフ編集処理中、Staffの更新に失敗しました。', ['error' => $e->getMessage()]);
                    throw $e;
                }

                // 画像をリクエストから取得する
                $picture = $request->file(config('const.form.admin.shop.staff.PICTURE') . '_' . $rank);
                if ($picture !== null) {
                    // 新規選択画像をストレージに保存する
                    app()->make('image_edit')->setImage($picture)->resizeTo('s')->encode('jpg',  config('const.common.image.ENCODE_QUALITY'))->save("shop/{$shop_id}/staff", "staff_{$rank}");
                }
            }
        }

        // 通知メッセージの登録
        NoticeMessage::adminShopStaff();

        return redirect()->route('admin.shop.staff', ['shop_id' => $shop_id]);
    }
}
