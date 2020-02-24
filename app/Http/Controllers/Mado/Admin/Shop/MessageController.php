<?php

namespace App\Http\Controllers\Mado\Admin\Shop;

use App\Facades\{
    MadoLog,
    NoticeMessage
};
use App\Http\Controllers\Controller;
use App\Http\Requests\Mado\Admin\Shop\MessageRequest;
use App\Models\EmergencyMessage;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index(Request $request, $shop_id)
    {
        try {
            // 緊急メッセージを取得する
            // 取得時にレコードが存在しなければ作成する
            $emergencyMessage = EmergencyMessage::firstOrCreate([
                config('const.db.emergency_messages.SHOP_ID') => $shop_id,
            ]);
            MadoLog::info('Ss012 緊急メッセージ新規登録処理中、EmergencyMessageの作成に完了しました。');
        } catch (\Exception $e) {
            MadoLog::error('Sf012 緊急メッセージ新規登録処理中、EmergencyMessageの作成に失敗しました。', ['error' => $e->getMessage()]);
            throw $e;
        }

        return view('mado.admin.shop.message.index', [
            'emergencyMessage' => $emergencyMessage,
        ]);
    }

    public function edit(MessageRequest $request, $shop_id)
    {
        // 緊急メッセージを取得する
        $emergencyMessage = EmergencyMessage::shopId($shop_id)->first();
        
        try {
            // 更新
            $emergencyMessage->fill($request->all())->save();
            MadoLog::info('Ss013 緊急メッセージ更新処理中、EmergencyMessageの更新に完了しました。');
        } catch (\Exception $e) {
            MadoLog::error('Sf013 緊急メッセージ更新処理中、EmergencyMessageの更新に失敗しました。', ['error' => $e->getMessage()]);
            throw $e;
        }

        // 通知メッセージの登録
        NoticeMessage::adminShopEmergencyMessage();

        return redirect()->route('admin.shop.message', ['shop_id' => $shop_id]);
    }

}
