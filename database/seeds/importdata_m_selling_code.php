<?php

use Illuminate\Database\Seeder;
use App\Lib\ImportDataDb;
use Illuminate\Support\Facades\log;

class importdata_m_selling_code extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $import = new ImportDataDb();
        $txt_file = storage_path() . '/import_data/m_selling_code.txt';
        $table = 'm_selling_code';
        //$column_db = ['m_color_id', 'ctg_prod_id', 'img_path', 'img_name', 'del_flg'];	
        if ($import->truncate_db($table)) {
            echo "$table TRUNCATE OK!" .PHP_EOL;
        }
        if (file_exists($txt_file) === true) {
            $datas = $import->extract_data_from_txt($txt_file, 2, 3);
            $column_db = array_map('trim', $datas['columns']);
            $list_data = $import->generate_columndb_value($datas['datas'], $column_db);
            foreach ($list_data as $k => $data) {
                $flg = 0;
            	foreach ($column_db as $value) {
	            	if ($data[$value] == '') {
                        $flg += 1; 
	                    $list_data[$k][$value] = NULL;
	                }
            	}
                if($flg == count($column_db))
                {
                    break;
                }
                else
                {
                    $data_insert[] = $list_data[$k];
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
