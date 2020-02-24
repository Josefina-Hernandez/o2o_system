<?php

use Illuminate\Database\Seeder;

class StandardPhotosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (app()->isLocal()) {
            DB::table('standard_photos')->insert([
                    'id' => 1,
                    'shop_id' => 3,
                    'title' => str_random(20),
                    'summary' => str_random(20),
                    'main_text' => str_random(20),
                    'before_text' => str_random(20),
                    'after_text' => str_random(20),
                    'is_customer_publish' => 0,
                    'category' => 4,
                    'parts' => '["3","4"]',
                    'locale' => str_random(20),
                    'period' => str_random(20),
                    'product' => str_random(20),
                    'created_at' => now()->subDays(2),
                    'updated_at' => now(),
                     'reason' => '',
                    'built_year' => 0,
                    'category_for_search' => '',
                    'pet' => '',
                    'customer_text_2' => '',
       
                
            ]);
            DB::table('standard_photos')->insert([
                    'id' => 2,
                    'shop_id' => 3,
                    'title' => str_random(20),
                    'summary' => str_random(20),
                    'main_text' => str_random(20),
                    'before_text' => str_random(20),
                    'after_text' => str_random(20),
                    'is_customer_publish' => 0,
                    'category' => 4,
                    'parts' => '["3","4"]',
                    'locale' => str_random(20),
                    'period' => str_random(20),
                    'product' => str_random(20),
                    'created_at' => now()->subMonth(3),
                    'updated_at' => now(),
                      'reason' => '',
                    'built_year' => 0,
                    'category_for_search' => '',
                    'pet' => '',
                    'customer_text_2' => '',
            ]);
            DB::table('standard_photos')->insert([
                    'id' => 3,
                    'shop_id' => 3,
                    'title' => str_random(20),
                    'summary' => str_random(20),
                    'main_text' => str_random(20),
                    'before_text' => str_random(20),
                    'after_text' => str_random(20),
                    'is_customer_publish' => 0,
                    'category' => 4,
                    'parts' => '["3","4"]',
                    'locale' => str_random(20),
                    'period' => str_random(20),
                    'product' => str_random(20),
                    'created_at' => now()->subMonth(4),
                    'updated_at' => now(),
                      'reason' => '',
                    'built_year' => 0,
                    'category_for_search' => '',
                    'pet' => '',
                    'customer_text_2' => '',
            ]);
            DB::table('standard_photos')->insert([
                    'id' => 4,
                    'shop_id' => 3,
                    'title' => str_random(20),
                    'summary' => str_random(20),
                    'main_text' => str_random(20),
                    'before_text' => str_random(20),
                    'after_text' => str_random(20),
                    'is_customer_publish' => 1,
                    'category' => 4,
                    'parts' => '["3","4"]',
                    'locale' => str_random(20),
                    'period' => str_random(20),
                    'product' => str_random(20),
                    'created_at' => now()->subDays(2),
                    'updated_at' => now(),
                      'reason' => '',
                    'built_year' => 0,
                    'category_for_search' => '',
                    'pet' => '',
                    'customer_text_2' => '',
            ]);
            DB::table('standard_photos')->insert([
                    'id' => 5,
                    'shop_id' => 3,
                    'title' => str_random(20),
                    'summary' => str_random(20),
                    'main_text' => str_random(20),
                    'before_text' => str_random(20),
                    'after_text' => str_random(20),
                    'is_customer_publish' => 1,
                    'category' => 4,
                    'parts' => '["3","4"]',
                    'locale' => str_random(20),
                    'period' => str_random(20),
                    'product' => str_random(20),
                    'created_at' => now()->subMonth(3),
                    'updated_at' => now(),
                      'reason' => '',
                    'built_year' => 0,
                    'category_for_search' => '',
                    'pet' => '',
                    'customer_text_2' => '',
            ]);
            DB::table('standard_photos')->insert([
                    'id' => 6,
                    'shop_id' => 3,
                    'title' => str_random(20),
                    'summary' => str_random(20),
                    'main_text' => str_random(20),
                    'before_text' => str_random(20),
                    'after_text' => str_random(20),
                    'is_customer_publish' => 1,
                    'category' => 4,
                    'parts' => '["3","4"]',
                    'locale' => str_random(20),
                    'period' => str_random(20),
                    'product' => str_random(20),
                    'created_at' => now()->subMonth(4),
                    'updated_at' => now(),
                     'reason' => '',
                    'built_year' => 0,
                    'category_for_search' => '',
                    'pet' => '',
                    'customer_text_2' => '',
            ]);
        }
    }
}
