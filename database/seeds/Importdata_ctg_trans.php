<?php

use Illuminate\Database\Seeder;
use App\Lib\ImportDataDb;
use Illuminate\Support\Facades\Log;

class Importdata_ctg_trans extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       	$import = new ImportDataDb();
        $txt_file = storage_path() . '/import_data/ctg_trans.txt';
        $table = 'ctg_trans';
        //$column_db = ['ctg_id', 'm_lang_id', 'ctg_name', 'del_flg'];

        if ($import->truncate_db($table)) {
            echo "$table TRUNCATE OK!" .PHP_EOL;
        }
        if (file_exists($txt_file) === true) {
            $datas = $import->extract_data_from_txt($txt_file, 2, 3);
            $column_db = array_map('trim', $datas['columns']);
            $data_insert = $import->generate_columndb_value($datas['datas'], $column_db);
            foreach ($data_insert as $k => $data) {
                foreach ($column_db as $value) {
                    if ($data[$value] == '') {
                        $data_insert[$k][$value] = NULL;
                    }
                }
            }
            DB::statement('SET FOREIGN_KEY_CHECKS = 0');
            if ($import->insert_db($table, $data_insert) === true) {
                echo "OK!" . PHP_EOL;
            } else {
                echo "Seeder table: $table fail, please check log file!" . PHP_EOL;
            }
            DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        } else {
            echo "Seeder table: $table fail, file " . basename($txt_file) . " not exists!" . PHP_EOL;
        }
    }
}
