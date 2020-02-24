<?php

namespace App\Services;

use App\Models\Pref;
use App\Models\City;
use Carbon\Carbon;

/**
 * KEN_ALL.CSVやADD_YYMM.csvを読み込み、市区町村新規登録を行う
 */
class CitiesCsvService
{
    // SplFileObjectで読み込んだCSVファイルの配列
    private $file = [];

    // CSVファイルから抽出した市区町村のデータ
    private $cities = [];

    /**
     * 日本郵便が配布している郵便番号データの全国一括（KEN_ALL.CSV）を
     * データベースに新規登録
     */
    public function insertCities()
    {
        // laravel/strage/app/private/csv配下に保存されたKEN_ALL.CSVを読み込む
        $this->file = app()->make('csv')->readCsv(storage_path('app/private/csv/KEN_ALL.CSV'));

        // 市区町村データを抽出する
        $this->insertCitiesList();

        // データベースに新規登録
        \DB::table('cities')->insert($this->cities['insert']);
    }

    /**
     * 読み込んだCSVデータから市区町村を抽出
     * 市区町村がすべて新規登録の場合に利用する
     */
    private function insertCitiesList()
    {
        // 直前に抽出した市区町村コード
        $set_code = '';

        foreach ($this->file as $line) {
            // UTF-8に変換
            $line = app()->make('csv')->convertLineToUTF8($line);

            // 読み込み済みの市区町村であるか
            if ($set_code !== $line[0]) {
                $set_code = $line[0];

                // 市区町村の属する都道府県を取得
                $pref = Pref::name($line[6])->first();

                // データを新規登録するリストへ追加
                $this->cities['insert'][] = [
                    'pref_id' => $pref->{config('const.db.prefs.ID')},
                    'code' => $line[0],
                    'name' => $line[7],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
        }
    }

    /**
     * 日本郵便が配布している郵便番号データの新規追加データ（ADD_YYMM.ZIP）を
     * データベースに未登録の市区町村コードを持つものは新規登録
     * データベースに登録済みの市区町村で市区町村名に変更があった場合は更新
     * 
     * @param string $fileName CSVファイル名
     */
    public function saveCities($fileName)
    {
        // laravel/strage/app/private/csv配下に保存された指定ファイルを読み込む
        $this->file = app()->make('csv')->readCsv(storage_path('app/private/csv/' . $fileName));

        // 市区町村データを抽出する
        $this->saveCitiesList();

        // データベースに新規登録
        if (! empty($this->cities['insert'])) {
            \DB::table('cities')->insert($this->cities['insert']);

        // データベースの更新
        } elseif (! empty($this->cities['save'])) {
            foreach ($this->cities['save'] as $data) {
                $city = City::find($data['id'])->fill($data);
                $city->save();
            }
        }
    }

    /**
     * 読み込んだCSVデータから市区町村を抽出
     * データベースに登録済みの市区町村が含まれる場合に利用する
     */
    private function saveCitiesList()
    {
        // 直前に抽出した市区町村コード
        $set_code = '';

        foreach ($this->file as $line) {
            // UTF-8に変換
            $line = app()->make('csv')->convertLineToUTF8($line);

            // 読み込み済みの市区町村であるか
            if ($set_code !== $line[0]) {
                $set_code = $line[0];

                // 市区町村の属する都道府県を取得
                $pref = Pref::name($line[6])->first();
                // 市区町村がデータベースに存在するか
                $city = City::code($line[0])->first();

                // 市区町村がデータベースに存在しなければ、データを新規登録するリストに追加
                if ($city === null) {
                    $this->cities['insert'][] = [
                        'pref_id' => $pref->{config('const.db.prefs.ID')},
                        'code' => $line[0],
                        'name' => $line[7],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];

                // データベースに存在する市区町村で、市区町村名に変更があればデータを更新するリストに追加
                } else if ($city->{config('const.db.cities.NAME')} !== $line[7]) {
                    $this->cities['save'][] = [
                        'id' => $city->{config('const.db.cities.ID')},
                        'name' => $line[7],
                    ];
                }
            }
        }
    }
}
