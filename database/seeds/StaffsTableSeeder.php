<?php

use Illuminate\Database\Seeder;

class StaffsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (app()->isLocal()) {
            DB::table('staffs')->insert([
                'id' => 1,
                'shop_id' => 3,
                'rank' => 1,
                'post' => str_random(20),
                'name' => str_random(20),
                'message' => str_random(100),
                'created_at' => now(),
                'updated_at' => now()
            ]);
            DB::table('staffs')->insert([
                'id' => 2,
                'shop_id' => 3,
                'rank' => 2,
                'post' => str_random(20),
                'name' => str_random(20),
                'message' => str_random(100),
                'created_at' => now()->subDays(3),
                'updated_at' => now()
            ]);
        }
    }
}
