<?php

use Illuminate\Database\Seeder;
use App\Lib\ImportDataDb;

class importdata_m_selling_spec_trans extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $import = new ImportDataDb();
     
        $table = 'm_selling_spec_trans';
        //$column_db = ['spec_code', 'm_lang_id', 'spec_name', 'del_flg'];	

        if ($import->truncate_db($table)) {
            echo "$table TRUNCATE OK!" .PHP_EOL;
        }
        
        $txt_file_lang_en = storage_path() . '/import_data/m_selling_spec_trans.txt';
        $this->_ImportDataToDB($import,$txt_file_lang_en,$table);// lang EN
        
        $txt_file_lang_th = storage_path() . '/import_data/m_selling_spec_trans_THAI.txt';
        $this->_ImportDataToDB($import,$txt_file_lang_th,$table,$lang="TH");// lang TH
        
         
        
        
    }
    
     public function _ImportDataToDB($import, $txt_file, $table, $lang='EN'){
          
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
                     echo "Lang ".$lang." OK!" . PHP_EOL;
                } else {
                     echo "Seeder table: $table Lang $lang fail, please check log file!" . PHP_EOL;
                }
                DB::statement('SET FOREIGN_KEY_CHECKS = 1');
            } else {
                echo "Seeder table: $table Lang $lang fail, file " . basename($txt_file) . " not exists!" . PHP_EOL;
            }
               
     }
    
}
