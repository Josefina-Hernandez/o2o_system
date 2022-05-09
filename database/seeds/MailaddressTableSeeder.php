<?php

use Illuminate\Database\Seeder;
use App\Lib\ImportDataDb;

class MailaddressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $import = new ImportDataDb();
        $table = 'm_mailaddress';
        if ($import->truncate_db($table)) {
            echo "$table TRUNCATE OK!" .PHP_EOL;
        }
        try {
        DB::transaction(function () {
            DB::table('m_mailaddress')->insert([
                [
                    'groupname' => 'CDC Showroom',
                    'department_code' => 'CDC',
                    'admin_flg' => '0',
                ],
                [   'groupname' => 'Boonthavorn',
                    'department_code' => 'BT1',
                    'admin_flg' => '0',
                ],
                [
                    'groupname' => 'Demo room Chaingmai',
                    'department_code' => 'DR1',
                    'admin_flg' => '0',
                ],
                [
                    'groupname' => 'Demo room Phuket',
                    'department_code' => 'DR2',
                    'admin_flg' => '0',
                ],
                [
                    'groupname' => 'Facebook',
                    'department_code' => 'FBK',
                    'admin_flg' => '0',
                ],
                [
                    'groupname' => 'Exhibition',
                    'department_code' => 'TDS',
                    'admin_flg' => '0',
                ],
                [
                    'groupname' => 'Dealer',
                    'department_code' => 'FAB',
                    'admin_flg' => '0',
                ],
                [
                    'groupname' => 'Sales',
                    'department_code' => 'LXT',
                    'admin_flg' => '0',
                ],
                [
                    'groupname' => 'Other',
                    'department_code' => 'MIS',
                    'admin_flg' => '0',
                ],
                [
                    'groupname' => 'End-user',
                    'department_code' => 'END',
                    'admin_flg' => '1',
                ],
                [
                    'groupname' => 'LINE',
                    'department_code' => 'LIN',
                    'admin_flg' => '0',
                ],
                [
                    'groupname' => 'Website',
                    'department_code' => 'WEB',
                    'admin_flg' => '0',
                ],
                [
                    'groupname' => 'Call-in',
                    'department_code' => 'CAL',
                    'admin_flg' => '0',
                ],
            ]);
        });
            echo "OK!" . PHP_EOL;
        } catch (Exception $e) {
            echo "Seeder table: $table fail, please check log file!" . PHP_EOL;
        }
        
    }
}
