<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class OauthClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (app()->isLocal()) {
            DB::table('oauth_clients')->insert([
                'id' => 1,
                'user_id' => 2,
                'name' => 'mado',
                'secret' => 'IZimCULCCiGGcYxcKSau9lrK6bqXEpyZPlHriC2z',
                'redirect' => 'https://madohonpo.jp.local/auth/callback',
                'personal_access_client' => 0,
                'password_client' => 0,
                'revoked' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
