<?php

use Illuminate\Database\Seeder;

class StandardArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (app()->isLocal()) {
            DB::table('standard_articles')->insert([
                'id' => 1,
                'shop_id' => 3,
                'category' => 1,
                'published_at' => now(),
                'title' => str_random(20),
                'summary' => str_random(20),
                'text' => str_random(20),
                'created_at' => now()->subDays(2),
                'updated_at' => now()
            ]);
            DB::table('standard_articles')->insert([
                'id' => 2,
                'shop_id' => 3,
                'category' => 2,
                'published_at' => now(),
                'title' => str_random(20),
                'summary' => str_random(20),
                'text' => str_random(20),
                'created_at' => now()->subMonth(3),
                'updated_at' => now()
            ]);
            DB::table('standard_articles')->insert([
                'id' => 3,
                'shop_id' => 3,
                'category' => 1,
                'published_at' => now(),
                'title' => str_random(20),
                'summary' => str_random(20),
                'text' => str_random(20),
                'created_at' => now()->subMonth(4),
                'updated_at' => now()
            ]);
            DB::table('standard_articles')->insert([
                'id' => 4,
                'shop_id' => 3,
                'category' => 1,
                'published_at' => now(),
                'title' => str_random(20),
                'summary' => str_random(20),
                'text' => str_random(20),
                'created_at' => now()->subDays(2),
                'updated_at' => now()
            ]);
            DB::table('standard_articles')->insert([
                'id' => 5,
                'shop_id' => 3,
                'category' => 1,
                'published_at' => now(),
                'title' => str_random(20),
                'summary' => str_random(20),
                'text' => str_random(20),
                'created_at' => now()->subMonth(3),
                'updated_at' => now()
            ]);
            DB::table('standard_articles')->insert([
                'id' => 6,
                'shop_id' => 3,
                'category' => 2,
                'published_at' => now(),
                'title' => str_random(20),
                'summary' => str_random(20),
                'text' => str_random(20),
                'created_at' => now()->subMonth(4),
                'updated_at' => now()
            ]);
        }
    }
}
