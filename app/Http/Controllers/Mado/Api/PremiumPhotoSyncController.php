<?php

namespace App\Http\Controllers\Mado\Api;

use App\Facades\MadoLog;
use App\Http\Controllers\Controller;
use App\Models\PremiumPhoto;
use Illuminate\Http\Request;

class PremiumPhotoSyncController extends Controller
{
    public function __construct()
    {
        //
    }

    /**
     * PRM店舗の事例をポータルサイトに新規作成または更新をするためのAPIに利用
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // PRM店舗から送信された値の取得
        $shopId = $request->shop_id;
        $articleId = $request->wp_article_id;

        // 事例を取得する
        $photo = PremiumPhoto::shopId($shopId)->wpArticle($articleId)->first();
        $isSuccess = null;
        if ($photo === null) {
            try {
                // 事例が取得できていない場合は新規作成する
                $photo = PremiumPhoto::create($request->all());
                MadoLog::info('As001 プレミアム施工事例同期処理中、PremiumPhotoの作成に完了しました。');
                $isSuccess = true;
    
            } catch (\Exception $e) {
                MadoLog::info('Af001 プレミアム施工事例同期処理中、PremiumPhotoの作成に失敗しました。', ['error' => $e->getMessage()]);
                $isSuccess = false;
            }

        } else {
            // 事例が存在する場合は事例内容の更新
            $photo->fill($request->all());

            try {
                // 事例の更新を確定する
                $photo->save();
                MadoLog::info('As002 プレミアム施工事例同期処理中、PremiumPhotoの更新に完了しました。');
                $isSuccess = true;
    
            } catch (\Exception $e) {
                MadoLog::info('Af002 プレミアム施工事例同期処理中、PremiumPhotoの更新に失敗しました。', ['error' => $e->getMessage()]);
                $isSuccess = false;
            }
        }
        
        return \Response::json(['is_success' => $isSuccess]);
    }

    /**
     * PRM店舗の事例をポータルサイトから削除するためのAPIに利用
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // PRM店舗から送信された値の取得
        $shopId = $request->shop_id;
        $articleId = $request->wp_article_id;

        $photo = PremiumPhoto::shopId($shopId)->wpArticle($articleId)->first();
        $isSuccess = null;
        // 事例が取得できていない場合は処理を終了する
        if ($photo === null) {
            MadoLog::info('Af003 プレミアム施工事例同期処理中、PremiumPhotoの取得に失敗しました。', ['shop_id' => $shopId, 'wp_article_id' => $articleId]);
            $isSuccess = false;

        } else {
            try {
                // 事例を削除する
                $photo->delete();
                MadoLog::info('As004 プレミアム施工事例同期処理中、PremiumPhotoの削除に完了しました。');
                $isSuccess = true;
    
            } catch (\Exception $e) {
                MadoLog::info('Af004 プレミアム施工事例同期処理中、PremiumPhotoの削除に失敗しました。', ['error' => $e->getMessage()]);
                $isSuccess = false;
            }
        }

        return \Response::json(['is_success' => $isSuccess]);
    }
}
