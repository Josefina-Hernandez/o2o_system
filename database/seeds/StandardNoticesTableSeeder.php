<?php

use Illuminate\Database\Seeder;

class StandardNoticesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (app()->isLocal()) {
            DB::table('standard_notices')->insert([
                'id' => 1,
                'shop_id' => 3,
                'published_at' => now(),
                'text' => str_random(100),
                'created_at' => now(),
                'updated_at' => now()
            ]);
            DB::table('standard_notices')->insert([
                'id' => 2,
                'shop_id' => 3,
                'published_at' => now()->subDays(3),
                'text' => str_random(100),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
