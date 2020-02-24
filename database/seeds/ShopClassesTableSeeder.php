<?php

use Illuminate\Database\Seeder;

class ShopClassesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $classes = config('const.common.shops.classes_name');

        DB::table('shop_classes')->insert([
            'id' => 1,
            'name' => $classes[1],
        ]);
        DB::table('shop_classes')->insert([
            'id' => 2,
            'name' => $classes[2],
        ]);
        DB::table('shop_classes')->insert([
            'id' => 3,
            'name' => $classes[3],
        ]);
        DB::table('shop_classes')->insert([
            'id' => 4,
            'name' => $classes[4],
        ]);
    }
}
