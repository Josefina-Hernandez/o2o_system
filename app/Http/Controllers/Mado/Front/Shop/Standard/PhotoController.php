<?php

namespace App\Http\Controllers\Mado\Front\Shop\Standard;

use App\Http\Controllers\Controller;
use App\Models\{
    Shop,
    StandardPhoto
};
use Illuminate\Http\Request;
use PhpParser\PrettyPrinter\Standard;

class PhotoController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index(Request $request, $pref_code, $shop_code)
    {
        // ショップの取得
        $shop = Shop::code($shop_code)->prefCode($pref_code)->first();
        
        // 事例の取得
        $standardPhotos = StandardPhoto::shopId($shop->{config('const.db.shops.ID')})->newly()->paginate(16);

        return view('mado.front.shop.standard.photo.index', [
            'shop' => $shop,
            'standardPhotos' => $standardPhotos,
        ]);
    }

    public function search(Request $request, $pref_code, $shop_code)
    {
        // ショップの取得
        $shop = Shop::code($shop_code)->prefCode($pref_code)->first();

        // 検索ワードをクエリパラメータに保持する
        $standardPhotos = StandardPhoto::shopId($shop->{config('const.db.shops.ID')})->searchFrontShopStandard($request->query())->newly()->paginate(16);

        // ブラウザ上に表示する検索ワード
        $keywords = array_key_exists(config('const.form.common.SEARCH_KEYWORDS'), $request->query())
            ? $request->query(config('const.form.common.SEARCH_KEYWORDS'))
            : '';

        return view('mado.front.shop.standard.photo.index', [
            'shop' => $shop,
            'standardPhotos' => $standardPhotos,
            'keywords' => $keywords,
        ]);
    }

    public function detail(Request $request, $pref_code, $shop_code, $photo_id)
    {
        // ショップの取得
        $shop = Shop::code($shop_code)->prefCode($pref_code)->first();

        // 事例を取得する
        $standardPhoto = StandardPhoto::find($photo_id);

        // 事例のショップIDと、ショップのショップIDが一致していない場合、404
        if ($shop->{config('const.db.shops.ID')} != $standardPhoto->{config('const.db.standard_photos.SHOP_ID')}) {
            abort(404);
        }

        // 事例の施工前写真と施工後写真を取得する
        $beforePictures = $standardPhoto->photoBeforeImageUrls();
        $afterPictures = $standardPhoto->photoAfterImageUrls();

        // 前後の事例を取得する
        $previousStandardPhoto = $standardPhoto->previous();
        $nextStandardPhoto = $standardPhoto->next();

        return view('mado.front.shop.standard.photo.detail', [
            'shop' => $shop,
            'standardPhoto' => $standardPhoto,
            'beforePictures' => $beforePictures,
            'afterPictures' => $afterPictures,
            'previousStandardPhoto' => $previousStandardPhoto,
            'nextStandardPhoto' => $nextStandardPhoto,
        ]);
    }

}
