<?php

namespace App\Services;

use App\Models\{
    City,
    Shop
};
use Illuminate\Database\Eloquent\Collection;

/**
 * ショップを市区町村という観点から絞り込んで取得するクラス
 */
class GetShopsByCityService
{
    /**
     * ショップを市区町村別にグループ分けする。
     * 引数にショップを指定しなかった場合、全ショップが対象となる。
     * 
     * @param Illuminate\Database\Eloquent\Collection $shops
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function groupByCity(\Illuminate\Database\Eloquent\Collection $shops = null)
    {
        if ($shops === null) {
            $shops = Shop::get();
        }

        return $shops
            ->groupBy(config('const.db.shops.CITY_ID'))
            ->keyBy(function ($item, $key) {
                // キーを市区町村コードにする
                $city = City::find($key);
                return $city->{config('const.db.cities.CODE')};
            });
    }
}
