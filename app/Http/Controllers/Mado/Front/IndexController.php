<?php

namespace App\Http\Controllers\Mado\Front;

use App\Models\Shop;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index(Request $request)
    {
        // 都道府県別に店舗を取得する
        $shops = Shop::isPublic()->get();
        $shopsByPref = app()->make('get_shops_by_pref')->groupByPref($shops);

        // 全国の施工事例を取得する
        $photosHavingVoice = app()->make('get_photo')->notHaveVoice(4);

        // お客様の声を取得する
        $photosNotHavingVoice = app()->make('get_photo')->hasVoice(4);

        // 現場ブログを取得する
        $articleBlogs = app()->make('get_article')->blog(4);

        // イベント・キャンペーンを取得する
        $articleEvents = app()->make('get_article')->event(4);

        return view('mado.front.index', [
            'prefs' => app()->make('get_list')->getPrefCodeList(),
            'shopsByPref' => $shopsByPref,
            'photosHavingVoice' => $photosHavingVoice,
            'photosNotHavingVoice' => $photosNotHavingVoice,
            'articleBlogs' => $articleBlogs,
            'articleEvents' => $articleEvents,
        ]);
    }

    public function sitemap(Request $request)
    {
        return view('mado.front.sitemap');
    }

    public function privacy(Request $request)
    {
        return view('mado.front.privacy.index');
    }
}
