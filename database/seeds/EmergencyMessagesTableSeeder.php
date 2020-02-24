<?php

use Illuminate\Database\Seeder;

class EmergencyMessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (app()->isLocal()) {
            DB::table('emergency_messages')->insert([
                'id' => 1,
                'shop_id' => 3,
                'text' => str_random(100),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
