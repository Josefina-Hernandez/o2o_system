<?php

namespace App\Http\Controllers\Mado\Admin\Shop;

use App\Facades\{
    MadoLog,
    NoticeMessage
};
use App\Http\Controllers\Controller;
use App\Http\Requests\Mado\Admin\Shop\NewsRequest;
use App\Models\StandardNotice;
use Illuminate\Http\Request;
use PhpParser\PrettyPrinter\Standard;

class NewsController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index(Request $request, $shop_id)
    {
        // 新規インスタンスを渡す
        $standardNotice = new StandardNotice([config('const.db.standard_notices.SHOP_ID') => $shop_id]);

        // 公開日を降順としたお知らせ一覧を取得
        $standardNoticesList = StandardNotice::shopId($shop_id)->newly()->get();

        return view('mado.admin.shop.news.index', [
            'standardNotice' => $standardNotice,
            'standardNoticesList' => $standardNoticesList,
        ]);
    }

    public function edit(Request $request, $shop_id, $notice_id)
    {
        // お知らせを取得する
        $standardNotice = StandardNotice::find($notice_id);

        // 公開日を降順としたお知らせ一覧を取得
        $standardNoticesList = StandardNotice::shopId($shop_id)->newly()->get();

        return view('mado.admin.shop.news.index', [
            'standardNotice' => $standardNotice,
            'standardNoticesList' => $standardNoticesList,
        ]);
    }

    public function register(NewsRequest $request, $shop_id)
    {
        $id = $request->input(config('const.db.standard_notices.ID'));
        if ($id === null) {
            /**
             * 新規登録
             */
            // リクエストにショップIDを含める
            $inputs = array_add($request->all(), config('const.db.standard_notices.SHOP_ID'), $shop_id);

            try {
                // レコードの作成
                $standardNotice = StandardNotice::create($inputs);
                MadoLog::info('Ss014 スタンダードお知らせ新規登録処理中、StandardNoticeの作成に完了しました。');
            } catch (\Exception $e) {
                MadoLog::error('Sf014 スタンダードお知らせ新規登録処理中、StandardNoticeの作成に失敗しました。', ['error' => $e->getMessage()]);
                throw $e;
            }

        } else {
            /**
             * 編集
             */
            $standardNotice = StandardNotice::find($id)->fill($request->all());
            try {
                $standardNotice->save();
                MadoLog::info('Ss015 スタンダードお知らせ更新処理中、StandardNoticeの更新に完了しました。');
            } catch (\Exception $e) {
                MadoLog::error('Sf015 スタンダードお知らせ更新処理中、StandardNoticeの更新に失敗しました。', ['error' => $e->getMessage()]);
                throw $e;
            }
        }

        // 通知メッセージの登録
        NoticeMessage::adminShopNews();

        return redirect()->route('admin.shop.news', ['shop_id' => $shop_id]);
    }

    public function delete(Request $request, $shop_id, $notice_id)
    {
        $standardNotice = StandardNotice::find($notice_id);
        if ($standardNotice !== null) {
            try {
                $standardNotice->delete();
                MadoLog::info('Ss016 スタンダードお知らせ削除処理中、StandardNoticeの削除に完了しました。');
            } catch (\Exception $e) {
                MadoLog::error('Sf016 スタンダードお知らせ削除処理中、StandardNoticeの削除に失敗しました。', ['error' => $e->getMessage()]);
                throw $e;
            }
        }

        return redirect()->route('admin.shop.news', ['shop_id' => $shop_id]);
    }

}
