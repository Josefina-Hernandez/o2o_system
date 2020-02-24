<?php

use Illuminate\Database\Seeder;

class PrefsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $prefs = [
            ['code' => 'hokkaido', 'name' => '北海道'],
            ['code' => 'aomori', 'name' => '青森県'],
            ['code' => 'iwate', 'name' => '岩手県'],
            ['code' => 'miyagi', 'name' => '宮城県'],
            ['code' => 'akita', 'name' => '秋田県'],
            ['code' => 'yamagata', 'name' => '山形県'],
            ['code' => 'fukushima', 'name' => '福島県'],
            ['code' => 'ibaraki', 'name' => '茨城県'],
            ['code' => 'tochigi', 'name' => '栃木県'],
            ['code' => 'gumma', 'name' => '群馬県'],
            ['code' => 'saitama', 'name' => '埼玉県'],
            ['code' => 'chiba', 'name' => '千葉県'],
            ['code' => 'tokyo', 'name' => '東京都'],
            ['code' => 'kanagawa', 'name' => '神奈川県'],
            ['code' => 'niigata', 'name' => '新潟県'],
            ['code' => 'toyama', 'name' => '富山県'],
            ['code' => 'ishikawa', 'name' => '石川県'],
            ['code' => 'fukui', 'name' => '福井県'],
            ['code' => 'yamanashi', 'name' => '山梨県'],
            ['code' => 'nagano', 'name' => '長野県'],
            ['code' => 'gifu', 'name' => '岐阜県'],
            ['code' => 'shizuoka', 'name' => '静岡県'],
            ['code' => 'aichi', 'name' => '愛知県'],
            ['code' => 'mie', 'name' => '三重県'],
            ['code' => 'shiga', 'name' => '滋賀県'],
            ['code' => 'kyoto', 'name' => '京都府'],
            ['code' => 'osaka', 'name' => '大阪府'],
            ['code' => 'hyogo', 'name' => '兵庫県'],
            ['code' => 'nara', 'name' => '奈良県'],
            ['code' => 'wakayama', 'name' => '和歌山県'],
            ['code' => 'tottori', 'name' => '鳥取県'],
            ['code' => 'shimane', 'name' => '島根県'],
            ['code' => 'okayama', 'name' => '岡山県'],
            ['code' => 'hiroshima', 'name' => '広島県'],
            ['code' => 'yamaguchi', 'name' => '山口県'],
            ['code' => 'tokushima', 'name' => '徳島県'],
            ['code' => 'kagawa', 'name' => '香川県'],
            ['code' => 'ehime', 'name' => '愛媛県'],
            ['code' => 'kochi', 'name' => '高知県'],
            ['code' => 'fukuoka', 'name' => '福岡県'],
            ['code' => 'saga', 'name' => '佐賀県'],
            ['code' => 'nagasaki', 'name' => '長崎県'],
            ['code' => 'kumamoto', 'name' => '熊本県'],
            ['code' => 'oita', 'name' => '大分県'],
            ['code' => 'miyazaki', 'name' => '宮崎県'],
            ['code' => 'kagoshima', 'name' => '鹿児島県'],
            ['code' => 'okinawa', 'name' => '沖縄県'],
        ];

        DB::table('prefs')->insert($prefs);
    }
}
