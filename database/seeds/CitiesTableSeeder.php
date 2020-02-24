<?php

use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 市区町村テーブルを作成
        app()->make('cities_csv')->insertCities();
    }
}
