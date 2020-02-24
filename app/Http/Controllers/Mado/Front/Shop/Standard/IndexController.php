<?php

namespace App\Http\Controllers\Mado\Front\Shop\Standard;

use App\Facades\MadoLog;
use App\Http\Controllers\Controller;
use App\Models\{
    Banner,
    EmergencyMessage,
    Shop,
    Staff,
    StandardArticle,
    StandardNotice,
    StandardPhoto
};
use Illuminate\Http\Request;

class IndexController extends Controller
{
        public function __construct()
    {
        //
    }

    public function index(Request $request, $pref_code, $shop_code)
    {
        // ショップの取得
        $shop = Shop::code($shop_code)->prefCode($pref_code)->first();

        // 加盟店緊急メッセージの取得
        $emergencyMessage = EmergencyMessage::shopId($shop->{config('const.db.shops.ID')})->publish()->first();
        $emergencyMessageText = $emergencyMessage ? $emergencyMessage->{config('const.db.emergency_messages.TEXT')} : null;

        // 事例の取得
        $standardPhotos = StandardPhoto::shopId($shop->{config('const.db.shops.ID')})->newly()->take(6)->get();

        // 現場ブログの取得
        $standardArticleBlogs = StandardArticle::shopId($shop->{config('const.db.shops.ID')})->blog()->toDate()->newly()->take(6)->get();

        // イベント・キャンペーンの取得
        $standardArticleEvents = StandardArticle::shopId($shop->{config('const.db.shops.ID')})->event()->toDate()->newly()->take(6)->get();

        // お知らせの取得
        $standardNotices = StandardNotice::shopId($shop->{config('const.db.shops.ID')})->newly()->toDate()->take(10)->get();

        // バナーの取得
        $banners = Banner::shopId($shop->{config('const.db.shops.ID')})->enable()->orderBy(config('const.db.banners.RANK'))->get();

        return view('mado.front.shop.standard.index', [
            'shop' => $shop,
            'emergencyMessageText' => $emergencyMessageText,
            'standardPhotos' => $standardPhotos,
            'standardNotices' => $standardNotices,
            'banners' => $banners,
            'standardArticleBlogs' => $standardArticleBlogs,
            'standardArticleEvents' => $standardArticleEvents,
        ]);
    }

    public function news(Request $request, $pref_code, $shop_code)
    {
        // ショップの取得
        $shop = Shop::code($shop_code)->prefCode($pref_code)->first();

        // お知らせの取得
        $standardNotices = StandardNotice::shopId($shop->{config('const.db.shops.ID')})->newly()->paginate(20);

        return view('mado.front.shop.standard.news', [
            'shop' => $shop,
            'standardNotices' => $standardNotices,
        ]);
    }

    public function blog()
    {
        return view('mado.front.shop.standard.blog.index');
    }

    public function blogDetail()
    {
        return view('mado.front.shop.standard.blog.detail');
    }

    public function staff(Request $request, $pref_code, $shop_code)
    {
        // ショップの取得
        $shop = Shop::code($shop_code)->prefCode($pref_code)->first();

        // スタッフの取得
        $staffs = Staff::shopId($shop->{config('const.db.shops.ID')})->enable()->orderBy(config('const.db.staffs.RANK'))->get();

        return view('mado.front.shop.standard.staff.index', [
            'shop' => $shop,
            'staffs' => $staffs,
        ]);
    }

}
