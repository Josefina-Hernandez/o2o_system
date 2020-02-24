<?php

use Illuminate\Database\Seeder;

class MailaddressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_mailaddress')->insert([
            'groupname' => 'Boonthavorn',
        ]);
        DB::table('m_mailaddress')->insert([
            'groupname' => 'CDC',
        ]);
        DB::table('m_mailaddress')->insert([
            'groupname' => 'Demo room',
        ]);
        DB::table('m_mailaddress')->insert([
            'groupname' => 'Sales',
        ]);
    }
}
