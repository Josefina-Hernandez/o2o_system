<?php

namespace App\Services;

use App\Models\{
    City,
    Pref
};
use Illuminate\Database\Eloquent\Collection;

/**
 * モデルからidと特定のカラムを抽出し、連想配列にして取り出すクラス
 * [id1 => value1, id2 => value2]
 */
class GetListService
{
    /**
     * モデルから2つのカラムを抽出し、連想配列にして取り出す
     * 
     * @param Illuminate\Database\Eloquent\Collection $models 対象とするモデルの配列
     * @param string $valueColumn valueとするカラム名
     * @param string $keyColumn keyとするカラム名
     * @param string $headText 先頭の項目名
     * @return array idをkey、$columnNameカラムの値をvalueとする連想配列
     */
    public function list(Collection $models, string $valueColumn, string $keyColumn = 'id', string $headText = '選択してください')
    {
        return $models->prepend(['id' => 0, 'name' => $headText])->pluck($valueColumn, $keyColumn);
    }

    /**
     * 都道府県のidとnameの組み合わせを取得する
     * 
     * list()のラップ関数
     * 
     * @param string $headText 先頭の項目名
     * @return [id => name]の配列
     */
    public function getPrefList(string $headText = '選択してください')
    {
        return $this->list(Pref::all(), config('const.db.prefs.NAME'), config('const.db.prefs.ID'), $headText);
    }

    /**
     * 都道府県のcodeとnameの組み合わせを取得する
     * 
     * list()のラップ関数
     * 
     * @param string $headText 先頭の項目名
     * @return [code => name]の配列
     */
    public function getPrefCodeList(string $headText = '都道府県を選択する')
    {
        return $this->list(Pref::all(), config('const.db.prefs.NAME'), config('const.db.prefs.CODE'), $headText);
    }
    
    /**
     * 市区町村のidとnameの組み合わせを取得する
     * 
     * list()のラップ関数
     * 
     * @param $prefId 都道府県（prefs）のid
     * @return [id => name]の配列
     */
    public function getCityList($prefId)
    {
        $cities = City::prefId($prefId)->get();
        $list = $this->list($cities, config('const.db.cities.NAME'));
        return $list->map(function ($name, $id){
            return ['id' => $id, config('const.db.cities.NAME') => $name];
        });
    }
}
