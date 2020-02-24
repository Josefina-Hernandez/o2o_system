<?php

namespace App\Http\Controllers\Mado\Front\Shop\Standard;

use App\Http\Controllers\Controller;
use App\Models\{
    Shop,
    StandardArticle
};
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index(Request $request, $pref_code, $shop_code)
    {
        // ショップの取得
        $shop = Shop::code($shop_code)->prefCode($pref_code)->first();

        /**
         * 記事の取得
         */
        $standardArticles = StandardArticle::shopId($shop->{config('const.db.shops.ID')});

        // 記事カテゴリの指定
        $route = $request->route()->getName();
        if ($route === 'front.shop.standard.blog') {
            // 現場ブログ
            $standardArticles = $standardArticles->blog();
            
        } else if ($route === 'front.shop.standard.event') {
            // イベント・キャンペーン
            $standardArticles = $standardArticles->event();
        }
        
        // 絞り込み条件の指定
        $standardArticles = $standardArticles->toDate()->newly()->paginate(16);

        return view('mado.front.shop.standard.article.index', [
            'shop' => $shop,
            'standardArticles' => $standardArticles,
        ]);
    }

    public function detail(Request $request, $pref_code, $shop_code, $article_id)
    {
        // ショップの取得
        $shop = Shop::code($shop_code)->prefCode($pref_code)->first();

        // 記事の取得
        $standardArticle = StandardArticle::find($article_id);

        // 記事のショップIDと、ショップのショップIDが一致していない場合、404エラー
        if ($shop->{config('const.db.shops.ID')} != $standardArticle->{config('const.db.standard_articles.SHOP_ID')}) {
            abort(404);
        }

        // 記事のカテゴリと、URLに含まれるカテゴリ（blog/event）が合致していない場合は404エラー
        $route = $request->route()->getName();
        if (($route === 'front.shop.standard.blog.detail' && $standardArticle->isEvent())
            || ($route === 'front.shop.standard.event.detail' && $standardArticle->isBlog())) {
            abort(404);
        }

        return view('mado.front.shop.standard.article.detail', [
            'shop' => $shop,
            'standardArticle' => $standardArticle,
        ]);
    }
}
