<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\{
    LengthAwarePaginator,
    Paginator
};

/**
 * CollectionやArrayに対して操作を行うクラス
 */
class CollectionService
{
    /**
     * CollectionやArrayからページネーションを作成する
     *
     * @param array|Collection $items
     * @param int $perPage
     * @param int $page
     * @param array $options
     *
     * @return LengthAwarePaginator
     */
    public function paginate($items, $perPage, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        // 現在のパスを設定する
        $options = array_merge(['path' => Paginator::resolveCurrentPath()], $options);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    /**
     * ShopのCollectionを市区町村コードと施工事例数とプレミアムかスタンダードかでソートする。
     * 1. 市区町村コードを昇順する。
     * 2. 市区町村コードが同じであれば施工事例数を降順する。
     * 3. 施工事例数が同数であればプレミアムを優先する。
     *
     * @param Illuminate\Database\Eloquent\Collection $shops ショップ
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function sortShopByCityCodeAndPhotoCount($shops)
    {
        $shops = $shops instanceof Collection ? $shops : Collection::make($shops);

        return $shops->sort(function ($first, $second) {
            // 市区町村コードが同じであれば施工事例数でソートする。
            if ($first->city_id === $second->city_id) {
                if ($first->isPremium()) {
                    $first_photos = $first->premiumPhotos;

                    // スタンダードと同数の場合、プレミアムを優先して表示するため、
                    // 施工事例数に0.5を加算し、スタンダードの同数の事例数よりも0.5大きくする。
                    $first_photos = $first_photos->count() + 0.5;
                } else if ($first->isStandard()) {
                    $first_photos = $first->standardPhotos->count();
                }
                if ($second->isPremium()) {
                    $second_photos = $second->premiumPhotos;

                    // スタンダードと同数の場合、プレミアムを優先して表示するため、
                    // 施工事例数に0.5を加算し、スタンダードの同数の事例数よりも0.5大きくする。
                    $second_photos = $second_photos->count() + 0.5;
                } else if ($second->isStandard()) {
                    $second_photos = $second->standardPhotos->count();
                }

                // 紐付く施工事例数で降順ソートする。
                return $first_photos < $second_photos ? 1 : -1 ;
            }
            // 市区町村コードを昇順する。
            return $first->city->code < $second->city->code ? -1 : 1 ;
        });

    }

    /**
     * ShopのCollectionやArrayからCityを取得する。
     * 同じ市区町村があった場合、1つにまとめる。
     *
     * @param array|Illuminate\Database\Eloquent\Collection $shops
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getCitiesFromShops($shops)
    {
        $shops = $shops instanceof Collection ? $shops : Collection::make($shops);

        return $shops->map(function ($shop, $key) {
            return $shop->city;
        })->unique(function ($city) {
            return $city->{config('const.db.cities.ID')};
        });
    }

    /**
     * ShopのCollectionやArrayからPrefを取得する。
     * 同じ都道府県があった場合、1つにまとめる。
     *
     * @param array|Illuminate\Database\Eloquent\Collection $shops
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getPrefsFromShops($shops)
    {
        $shops = $shops instanceof Collection ? $shops : Collection::make($shops);

        return $shops->map(function ($shop, $key) {
            return $shop->pref;
        })->unique(function ($pref) {
            return $pref->{config('const.db.prefs.ID')};
        });
    }

    public function getMapDataFromShops($shops)
    {
        return $shops->map(function ($shop) {
            return [
                'name' => $shop->{config('const.db.shops.NAME')},
                'url' => $shop->siteUrl(),
                'latitude' => $shop->{config('const.db.shops.LATITUDE')},
                'longitude' => $shop->{config('const.db.shops.LONGITUDE')},
            ];
        });
    }

    /**
     * 都道府県ごとのShopの件数をカウントする。
     *
     * @param array|Illuminate\Database\Eloquent\Collection $shops
     * @param array|Illuminate\Database\Eloquent\Collection $prefs
     *
     * @return array $countShopsInPref 都道府県ごとのShop件数
     */
    public function countShopsInPref($shops)
    {
        $shops = $shops instanceof Collection ? $shops : Collection::make($shops);

        $countShopsInPref = [];

        foreach ($shops->pluck(config('const.db.shops.PREF_ID'))->unique() as $pref_id) {
            $countShopsInPref[$pref_id] = $shops->where(config('const.db.shops.PREF_ID'), $pref_id)->count();
        }

        return $countShopsInPref;
    }

    /**
     * 市区町村ごとのShopの件数をカウントする。
     *
     * @param array|Illuminate\Database\Eloquent\Collection $shops
     * @param array|Illuminate\Database\Eloquent\Collection $cities
     *
     * @return array $countShopsInCity 市区町村ごとのShop件数
     */
    public function countShopsInCity($shops)
    {
        $shops = $shops instanceof Collection ? $shops : Collection::make($shops);

        $countShopsInCity = [];

        foreach ($shops->pluck(config('const.db.shops.CITY_ID'))->unique() as $city_id) {
            $countShopsInCity[$city_id] = $shops->where(config('const.db.shops.CITY_ID'), $city_id)->count();
        }

        return $countShopsInCity;
    }
}
