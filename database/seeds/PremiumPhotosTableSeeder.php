<?php

use Illuminate\Database\Seeder;

class PremiumPhotosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (app()->isLocal()) {
            DB::table('premium_photos')->insert([
                'id' => 1,
                'shop_id' => 2,
                'posted_at' => now()->subMonth(3),
                'title' => str_random(20),
                'summary' => str_random(40),
                'is_customer_publish' => 0,
                'wp_article_id' => 1,
                'wp_article_url' => 'https://1.com/photo',
                'created_at' => now()->subMonth(1),
                'updated_at' => now()
            ]);
            DB::table('premium_photos')->insert([
                'id' => 2,
                'shop_id' => 2,
                'posted_at' => now()->subMonth(4),
                'title' => str_random(20),
                'summary' => str_random(40),
                'is_customer_publish' => 0,
                'wp_article_id' => 1,
                'wp_article_url' => 'https://2.com/photo',
                'created_at' => now()->subDays(1),
                'updated_at' => now()
            ]);
            DB::table('premium_photos')->insert([
                'id' => 3,
                'shop_id' => 2,
                'posted_at' => now()->subMonth(5),
                'title' => str_random(20),
                'summary' => str_random(40),
                'is_customer_publish' => 0,
                'wp_article_id' => 1,
                'wp_article_url' => 'https://3.com/photo',
                'created_at' => now()->subMonth(2),
                'updated_at' => now()
            ]);
            DB::table('premium_photos')->insert([
                'id' => 4,
                'shop_id' => 2,
                'posted_at' => now()->subMonth(3),
                'title' => str_random(20),
                'summary' => str_random(40),
                'is_customer_publish' => 1,
                'wp_article_id' => 1,
                'wp_article_url' => 'https://4.com/photo',
                'created_at' => now()->subMonth(1),
                'updated_at' => now()
            ]);
            DB::table('premium_photos')->insert([
                'id' => 5,
                'shop_id' => 2,
                'posted_at' => now()->subMonth(4),
                'title' => str_random(20),
                'summary' => str_random(40),
                'is_customer_publish' => 1,
                'wp_article_id' => 1,
                'wp_article_url' => 'https://5.com/photo',
                'created_at' => now()->subDays(1),
                'updated_at' => now()
            ]);
            DB::table('premium_photos')->insert([
                'id' => 6,
                'shop_id' => 2,
                'posted_at' => now()->subMonth(3),
                'title' => str_random(20),
                'summary' => str_random(40),
                'is_customer_publish' => 1,
                'wp_article_id' => 1,
                'wp_article_url' => 'https://6.com/photo',
                'created_at' => now()->subMonth(1),
                'updated_at' => now()
            ]);
        }
    }
}
