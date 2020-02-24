<?php

namespace App\Http\Controllers\Mado\Api;

use App\Facades\MadoLog;
use App\Http\Controllers\Controller;
use App\Models\PremiumArticle;
use Illuminate\Http\Request;

class PremiumArticleSyncController extends Controller
{
    public function __construct()
    {
        //
    }

    /**
     * プレミアム店舗の現場ブログまたはイベント・キャンペーンを
     * ポータルサイトに新規作成または更新をするためのAPIに利用
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // プレミアム店舗から送信された値の取得
        $shopId = $request->shop_id;
        $articleId = $request->wp_article_id;
        $category = $request->category;

        // 記事を取得する
        $article = PremiumArticle::shopId($shopId)->wpArticle($articleId)->category($category)->first();
        $isSuccess = null;
        if ($article === null) {
            try {
                // 記事が取得できていない場合は新規作成する
                $article = PremiumArticle::create($request->all());
                MadoLog::info('As005 プレミアム記事同期処理中、PremiumArticleの作成に完了しました。');
                $isSuccess = true;
    
            } catch (\Exception $e) {
                MadoLog::info('Af005 プレミアム記事同期処理中、PremiumArticleの作成に失敗しました。', ['error' => $e->getMessage()]);
                $isSuccess = false;
            }

        } else {
            // 記事が存在する場合は記事内容の更新
            $article->fill($request->all());
            try {
                // 記事の更新を確定する
                $article->save();
                MadoLog::info('As006 プレミアム記事同期処理中、PremiumArticleの更新に完了しました。');
                $isSuccess = true;
    
            } catch (\Exception $e) {
                MadoLog::info('Af006 プレミアム記事同期処理中、PremiumArticleの更新に失敗しました。', ['error' => $e->getMessage()]);
                $isSuccess = false;
            }
        }
        
        return \Response::json(['is_success' => $isSuccess]);
    }

    /**
     * プレミアム店舗の現場ブログまたはイベント・キャンペーンを
     * ポータルサイトから削除するためのAPIに利用
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // プレミアム店舗から送信された値の取得
        $shopId = $request->shop_id;
        $articleId = $request->wp_article_id;
        $category = $request->category;

        $article = PremiumArticle::shopId($shopId)->wpArticle($articleId)->category($category)->first();
        // 記事が取得できていない場合は処理を終了する
        if ($article === null) {
            MadoLog::info('Af007 プレミアム記事同期処理中、PremiumArticleの取得に失敗しました。', ['shop_id' => $shopId, 'wp_article_id' => $articleId]);
            $isSuccess = false;

        } else {
            try {
                // 記事を削除する
                $article->delete();
                MadoLog::info('As008 プレミアム記事同期処理中、PremiumArticleの削除に完了しました。');
                $isSuccess = true;
    
            } catch (\Exception $e) {
                MadoLog::info('As008 プレミアム記事同期処理中、PremiumArticleの削除に完了しました。');
                $isSuccess = false;
            }
        }

        return \Response::json(['is_success' => $isSuccess]);
    }
}
