<?php

namespace App\Services;

use App\Models\{
    Pref,
    Shop
};
use Illuminate\Database\Eloquent\Collection;

/**
 * ショップを都道府県という観点から絞り込んで取得するクラス
 */
class GetShopsByPrefService
{
    /**
     * ショップを都道府県別にグループ分けする。
     * 引数にショップを指定しなかった場合、全ショップが対象となる。
     * 
     * @param Illuminate\Database\Eloquent\Collection $shops
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function groupByPref(\Illuminate\Database\Eloquent\Collection $shops = null)
    {
        if ($shops === null) {
            $shops = Shop::get();
        }

        return $shops
            ->groupBy(config('const.db.shops.PREF_ID'))
            ->keyBy(function ($item, $key) {
                // キーを都道府県コードにする
                $pref = Pref::find($key);
                return $pref->{config('const.db.prefs.CODE')};
            });
    }
}
