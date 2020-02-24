<?php

namespace App\Http\Controllers\Mado\Front\Shop;

use App\Http\Controllers\Controller;
use App\Models\{
    City,
    Pref,
    PremiumPhoto,
    Shop,
    StandardPhoto
};
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __construct()
    {
        //
    }

    public function searchPref(Request $request, $pref_code)
    {
        // 都道府県を取得する
        $pref = Pref::code($pref_code)->first();

        // 指定された都道府県に属し、公開ステータスのショップを取得する
        $shops = Shop::prefCode($pref_code)->isPublic();

        // 見積りシミュレーションが可能なショップを絞り込む
        $simulate = $request->query(config('const.form.common.SIMULATE'));
        if ($simulate === config('const.form.common.CHECKED')) {
            $shops = $shops->canSimulate()->get();

        } else {
            $shops = $shops->get();
        }

        // googlemap表示用のデータを取得する
        $mapData = app()->make('collection')->getMapDataFromShops($shops)->toJson();

        // 市区町村コードで昇順し、同じ市区町村であれば施工事例数で降順し、施工事例数が同数の場合はプレミアムを優先する
        $shops = app()->make('collection')->sortShopByCityCodeAndPhotoCount($shops);

        // 市区町村ごとのショップ件数を取得する
        $countShopsInCity = app()->make('collection')->countShopsInCity($shops);

        // ページネーションを作成する
        $shops = app()->make('collection')->paginate($shops, 20);

        // 市区町村をショップから取得する
        // 重複する市区町村は1つにまとめる。
        $cities = app()->make('collection')->getCitiesFromShops($shops->getCollection());

        // 市区町村別にショップを取得する
        $shopsByCity = app()->make('get_shops_by_city')->groupByCity($shops->getCollection());

        return view('mado.front.shop.search.pref', [
            'shops' => $shops,
            'cities' => $cities,
            'shopsByCity' => $shopsByCity,
            'countShopsInCity' => $countShopsInCity,
            'pref' => $pref,
            'queryParams' => $request->query(),
            'mapData' => $mapData,
        ]);
    }

    public function searchCity(Request $request, $pref_code, $city_code)
    {
        // 市区町村を取得する
        $city = City::code($city_code)->first();

        // 市区町村に属するショップを取得する
        $shops = Shop::cityCode($city_code)->isPublic();
        
        // 見積りシミュレーションが可能なショップを絞り込む
        $simulate = $request->query(config('const.form.common.SIMULATE'));
        if ($simulate === config('const.form.common.CHECKED')) {
            $shops = $shops->canSimulate()->get();

        } else {
            $shops = $shops->get();
        }

        // 施工事例数で降順し、同数の場合はプレミアムを優先する
        $shops = app()->make('collection')->sortShopByCityCodeAndPhotoCount($shops);

        // ページネーションを作成する
        $shops = app()->make('collection')->paginate($shops, 20);

        return view('mado.front.shop.search.city', [
            'shops' => $shops,
            'city' => $city,
            'queryParams' => $request->query(),
        ]);
    }

    public function searchKeyword(Request $request)
    {
        // 検索ワードおよび見積りシミュレーションフラグの有無をクエリパラメータに保持する
        $shops = Shop::searchFrontKeyword($request->query())->isPublic()->get();

        // 市区町村コードで昇順し、同じ市区町村であれば施工事例数で降順し、施工事例数が同数の場合はプレミアムを優先する
        $shops = app()->make('collection')->sortShopByCityCodeAndPhotoCount($shops);

        // 都道府県ごとのショップ件数を取得する
        $countShopsInPref = app()->make('collection')->countShopsInPref($shops);

        // ページネーションを作成する
        $shops = app()->make('collection')->paginate($shops, 20);

        // 都道府県をショップから取得する
        // 重複する都道府県は1つにまとめる。
        $prefs = app()->make('collection')->getPrefsFromShops($shops->getCollection());

        // 都道府県別にショップを取得する
        $shopsByPref = app()->make('get_shops_by_pref')->groupByPref($shops->getCollection());

        // ブラウザ上に表示する検索ワード
        $keywords = array_key_exists(config('const.form.common.SEARCH_KEYWORDS'), $request->query())
            ? $request->query(config('const.form.common.SEARCH_KEYWORDS'))
            : '';

        return view('mado.front.shop.search.keyword', [
            'shops' => $shops,
            'prefs' => $prefs,
            'shopsByPref' => $shopsByPref,
            'countShopsInPref' => $countShopsInPref,
            'keywords' => $keywords,
            'queryParams' => $request->query(),
        ]);
    }

    public function photo(Request $request)
    {
        // 事例を取得する
        $photos = app()->make('get_photo')->allPublicNewly();

        // ページネーションを作成する
        $photos = app()->make('collection')->paginate($photos, 16);

        return view('mado.front.shop.photo', [
            'photos' => $photos,
        ]);
    }

    public function searchPhoto(Request $request)
    {
        // 検索条件に合致する各事例を取得する
        $premiumPhotos = PremiumPhoto::searchFront($request->query())->get();
        $standardPhotos = StandardPhoto::searchFront($request->query())->get();

        // 各事例をマージする
        $photos = app()->make('get_photo')->merge($premiumPhotos, $standardPhotos);
        $photos = app()->make('get_photo')->newly($photos);
        
        // ページネーションを作成する
        $photos = app()->make('collection')->paginate($photos, 16);

        // ブラウザ上に表示する検索ワード
        $keywords = array_key_exists(config('const.form.common.SEARCH_KEYWORDS'), $request->query())
            ? $request->query(config('const.form.common.SEARCH_KEYWORDS'))
            : '';

        return view('mado.front.shop.photo', [
            'photos' => $photos,
            'keywords' => $keywords,
            'queryParams' => $request->query(),
        ]);
    }

    public function prefModal(Request $request)
    {
        // 都道府県別に店舗を取得する
        $shops = Shop::isPublic()->get();
        $shopsByPref = app()->make('get_shops_by_pref')->groupByPref($shops);

        return view('mado.front.parts.pref_modal', [
            'prefs' => app()->make('get_list')->getPrefCodeList(),
            'shopsByPref' => $shopsByPref,
        ]);
    }

    public function prefModalEstimate(Request $request)
    {
        // 都道府県別に見積りシミュレーションを利用可能な店舗を取得する
        $shops = Shop::canSimulate()->isPublic()->get();
        $shopsByPref = app()->make('get_shops_by_pref')->groupByPref($shops);

        return view('mado.front.parts.pref_modal_estimate', [
            'prefs' => app()->make('get_list')->getPrefCodeList(),
            'shopsByPref' => $shopsByPref,
        ]);
    }

    public function article(Request $request)
    {
        // 記事カテゴリをルートから取得し、記事を取得する
        $route = $request->route()->getName();
        if ($route === 'front.shop.blog') {
            // 現場ブログ
            $articles = app()->make('get_article')->blog(null, false);
            
        } else if ($route === 'front.shop.event') {
            // イベント・キャンペーン
            $articles = app()->make('get_article')->event(null, false);
        }

        // ページネーションを作成する
        $articles = app()->make('collection')->paginate($articles, 16);

        return view('mado.front.shop.article', [
            'articles' => $articles,
        ]);
    }
}
