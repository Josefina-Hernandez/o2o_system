<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // LIXILユーザ
        DB::table('users')->insert([
            'shop_id' => 1,
            'shop_class_id' => 1,
            'admin' => 1,
            'login_id' => 'lixil',
            'password' => bcrypt('pass'),
            'name' => 'lixil',
            'status' => 1,
        ]);
        
        if (app()->isLocal()) {
            // プレミアムユーザ
            /*DB::table('users')->insert([
                'shop_id' => 2,
                'shop_class_id' => 2,
                'login_id' => 'premium',
                'password' => bcrypt('pass'),
                 'name' => 'premium',
                 'status' => 1,
            ]);
    
            // スタンダードユーザ
            DB::table('users')->insert([
                'shop_id' => 3,
                'shop_class_id' => 3,
                'login_id' => 'standard',
                'password' => bcrypt('pass'),
                 'name' => 'standard',
                 'status' => 1,
            ]);*/
              DB::table('users')->insert([
                'shop_id' => 4,
                'shop_class_id' => 4,
                'login_id' => 'employee',
                'password' => bcrypt('employee'),
                 'name' => 'employee',
                   'status' => 1,
            ]);
        }
    }
}