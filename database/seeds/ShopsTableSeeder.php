<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ShopsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shops')->insert([
            'id' => 1,
            'name' => 'lixil',
            'shop_class_id' => 1,
            'company_name' => str_random(20),
            'company_name_kana' => str_random(20),
            'kana' => str_random(20),
            'pref_id' => 1,
            'city_id' => 1,
            'street' => str_random(20),
            'email' => str_random(20) . '@example.com',
            'open_time' => Carbon::now(),
            'close_time' => Carbon::now(),
            'normally_close_day' => str_random(20),
            'support_detail_list' => '{}',
            'certificate' => str_random(200),
            'shop_code' => str_random(50),
            'deleted_at' => Carbon::now(),
        ]);
        
        if (app()->isLocal()) {
            DB::table('shops')->insert([
                'id' => 2,
                'name' => str_random(10),
                'shop_class_id' => 2,
                'company_name' => str_random(20),
                'company_name_kana' => str_random(20),
                'kana' => str_random(20),
                'pref_id' => 1,
                'city_id' => 1,
                'street' => str_random(20),
                'email' => str_random(20) . '@example.com',
                'open_time' => Carbon::now(),
                'close_time' => Carbon::now(),
                'premium_shop_domain' => 'example.com',
                'normally_close_day' => str_random(20),
                'support_detail_list' => '{}',
                'certificate' => str_random(200),
                'shop_code' => str_random(10),
            ]);
            DB::table('shops')->insert([
                'id' => 3,
                'name' => str_random(10),
                'shop_class_id' => 3,
                'company_name' => str_random(20),
                'company_name_kana' => str_random(20),
                'kana' => str_random(20),
                'pref_id' => 1,
                'city_id' => 1,
                'street' => str_random(20),
                'email' => str_random(20) . '@example.com',
                'open_time' => Carbon::now(),
                'close_time' => Carbon::now(),
                'normally_close_day' => str_random(20),
                'support_detail_list' => '{}',
                'certificate' => str_random(200),
                'shop_code' => str_random(10),
            ]);
            
            DB::table('shops')->insert([
                'id' => 4,
                'name' => "Employee",
                'shop_class_id' => 4,
                'company_name' => str_random(20),
                'company_name_kana' => str_random(20),
                'kana' => str_random(20),
                'pref_id' => 1,
                'city_id' => 1,
                'street' => str_random(20),
                'email' => str_random(20) . '@example.com',
                'open_time' => Carbon::now(),
                'close_time' => Carbon::now(),
                'normally_close_day' => str_random(20),
                'support_detail_list' => '{}',
                'certificate' => str_random(200),
                'shop_code' => str_random(10),
            ]);
            
            
        }
    }
}
