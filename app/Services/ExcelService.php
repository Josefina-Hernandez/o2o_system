<?php
namespace App\Services;

use Illuminate\Support\Facades\File;
use App\Services\ExcelModelService;

use App\Lib\ImportDataDb;
use Box\Spout\Writer\WriterFactory;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;
use Log;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Excel;

class ExcelService extends ExcelModelService
{
     private $_pdo;


     
     public $_path_file;
     
     public $_gen_resulf;
     
     public $_data_sesulf = [];
     
     private $_namefile;
     
     private $_name_table_tmp;
 
     private $_length_data = 0;
     
     private $_limit_leght = 2000;

     
     
     private $_path_log_excel;
     
     private $_path_file_txt;
     
     private $_name_sheet = 'data_result';
     
     private $_ext = 'xlsx';
     
     
     
     
     public function __construct($path_file,$object = [])
     {
          $this->_path_file =$path_file;
          
          if(isset(pathinfo($this->_path_file)['extension'])){
               $this->_ext = pathinfo($this->_path_file)['extension'];
          }
          
          $this->_pdo =  \DB::getPdo();
          if(is_object($object)){
               parent::__construct($object);
          }
     }
     
      
     public function setNamefile($namefile){
           $this->_namefile = $namefile;
     }
     
     public function setNametabletmp($_time_now){
          $this->_name_table_tmp = 'tbtmp_'.$_time_now;
     }
     
     public function setDatainsert($data){
          $this->_data_sesulf = $data;
     }
     
     public function _gen_file_txt(){
          $import = new ImportDataDb;
          $this->_path_file_txt = $import->export_txt_flow_list_sheet($this->_path_file, 0,true);
          $this->_path_file = $this->_path_file_txt;
          return $this->_path_file_txt;
      }
      public function _update_path($his_id){
            $this->_path_file = str_replace('/tmp/', '/'.$his_id.'/', $this->_path_file);
            return $this->_path_file;
      }

    public function _check_data_import(){
         
         $return = [];
         
        $file = @fopen($this->_path_file, 'r');
        $i = 0;
        $pos_null = [];
        $column_db = $this->_object->getColumnTmp();
        while (!feof($file)) {
            $row = fgets($file);
            if($i == 0 ){
                $column_ex = array_map('strtolower',  explode("_\\t,", trim($row)));
                foreach ($column_ex as $key => $value)
                {
                    if (!isset($column_db[$key]) || $value != $column_db[$key])
                        {
                            $return['status'] = 'err_column';
                            return $return;
                        }
                }
            }
            if($i > 0){
                if($row != ''){
                    $data = $this->_generate_columndb_value(explode("_\\t,", trim($row)), $column_ex);
                    foreach ($data as $key => $value) {
                        if($key != 'special' && $value == '')
                        {
                            switch ($key) {
                                case 'design':
                                    $column_name = 'A';
                                    break;
                                case 'width':
                                    $column_name = 'B';
                                    break;
                                case 'height':
                                    $column_name = 'C';
                                    break;
                                case 'amount':
                                    $column_name = 'E';
                                    break;
                            }
                            $pos = $i + 1;
                            $pos_null[] = $column_name.'_'.$pos;
                        }
                        
                    }
                    
                } 
            }
            $i++;     
        }
        $pos_null = implode(', ',$pos_null);
        if(strlen($pos_null) > 0)
        {
            $return['status'] = 'err_data';
            $return['pos_null'] = $pos_null;
        }
        return $return;
        
    } 

                   
     public function _insert_data_tmp(){
            try {    
                    $this->_create_table_tmp();   
                    $file = @fopen($this->_path_file, 'r');

                    $i = 0;
                    while (!feof($file)) {
                             $row = fgets($file);
                             if($i == 0 ){
                                  $columns = array_map('strtolower',  explode("_\\t,", trim($row)));
                             }
                             if($i > 0){
                                  if($row != ''){
                                       $this->_data_sesulf[] =  $this->_generate_columndb_value(explode("_\\t,", trim($row)), $columns);
                                  } 
                             }

                             if(count($this->_data_sesulf) == $this->_limit_leght){
                                  $this->_pdo->prepare($this->_query_db($this->_data_sesulf))->execute();
                                  $this->_length_data += count($this->_data_sesulf);
                                  $this->_data_sesulf  = NULL;
                             }
                        $i++;     
                    }

                   if(is_array($this->_data_sesulf)){
                            $this->_pdo->prepare($this->_query_db($this->_data_sesulf))->execute();
                            $this->_length_data += count($this->_data_sesulf);
                            $this->_data_sesulf  = NULL;
                    }
                    
                    return TRUE;
               } catch (Exception $ex) {
                      return FALSE;
              }
           
          return FALSE;
           
     }

     
    public function _insert_data(){
       
            try {
                    $this->_query_truncate();
                    $this->_pdo->prepare($this->_query_clone())->execute();  
                    $this->_query_delete_tmp();
                     return TRUE;
              } catch (Exception $ex) {
                       return FALSE;
              }
              
     }
   
     public function gen_file_log_excel(){
         
           $name_result = $this->_namefile.'_result.'.$this->_ext;
           
           $this->_path_log_excel = pathinfo($this->_path_file)['dirname'].'/'.$name_result;
           
           
           $writer = WriterFactory::create(Type::XLSX);
           $writer->openToFile($this->_path_log_excel);
           $writer->getCurrentSheet()->setName($this->_name_sheet);
           $writer->addRows([$this->_object->getColumnExport()]);
           
           
          $count = $this->_length_data / $this->_limit_leght;
          
          //Log::debug('length data '.$this->_length_data);
          
           for( $i = 1; $i <= ceil($count); $i++){
                
                 $limit = $i*$this->_limit_leght;
                
                 $data = $this->_query_export_data($limit);
                
                 $data = json_decode(json_encode($data),true);
                
                 $writer->addRows($data);
                 
                 unset($data);
                
           }
          
          
          $writer->close();
            
       }
      private function _generate_columndb_value($data, $columns){
          
          $count_column = count($columns);
          $result = [];

              $data_trim = [];
              foreach ($data as $key => $value) {
                  $data_trim[] = trim($value);
              }

              $count_data = count($data_trim);
              if ($count_data === $count_column) {
                  $result =  array_combine($columns, $data_trim);
              } else {
                  for ($i = 0; $i < $count_data - $count_column; $i++) { 
                      unset($data_trim[$count_data - $i - 1]);
                  }

                  $result = array_combine($columns, $data_trim);
              }


          return $result;
     } 
      private function _query_db($data){
         
           
           $value = '';
           $max_count = count($data)-1;
           $max_count_col =  count($this->_object->getColumnTmp())-1;
           
           foreach ($data as $k =>  $v){
               
                    $val = '(';
                   foreach ($this->_object->getColumnTmp() as $kt => $f){
                         if($f ==  config('const_db_tostem.db.product_selling_code_price.column.DESIGN') || $f ==  config('const_db_tostem.db.product_selling_code_price.column.WIDTH') || $f ==  config('const_db_tostem.db.product_selling_code_price.column.HEIGHT')){
                               $v[$f] = "'".$v[$f]."'";  
                         }
                         if($f ==  config('const_db_tostem.db.product_selling_code_price.column.SPECIAL') && $v[$f] != ''){
                               $v[$f] = "'".$v[$f]."'";
                         }

                         if($v[$f] == ''){
                               $v[$f] = 'NULL';  
                         }
                        if($kt < $max_count_col){
                            $val .= $v[$f].',';
                        }
                        if($kt == $max_count_col){
                            $val .= $v[$f];
                        }
                   }
                   if($k < $max_count){
                       $value .= $val .'),';
                   }
                   if($k == $max_count){
                       $value .= $val .')';
                   }
                   $val = '';
                
           }
           
          //$placeHolders = '(' . implode(', ', array_fill(0, count($this->_filltable), '?')) . ')';
          $query = "INSERT INTO ".$this->_name_table_tmp." (" . implode(', ', $this->_object->getColumnTmp()) . ") VALUES $value" ;
         
          unset($value);
          return $query;
          
      }
       
      private function _query_export_data($limit_end){
       
          $limit_start = $limit_end - $this->_limit_leght;
          
          $query = "
               SELECT tmp.design, tmp.width, tmp.height, tmp.special, tmp.amount, NULL AS col,
               CASE
                    WHEN  tb.amount IS NULL THEN 'Unmatch'
                    WHEN  tmp.amount = tb.amount THEN 'Same'
                    WHEN tmp.amount <> tb.amount THEN 'Update'
                END
                AS status

               FROM $this->_name_table_tmp AS tmp
               LEFT JOIN ".$this->_object->getTable()." AS tb ON tb.design <=> tmp.design  AND  tb.width <=> tmp.width  AND  tb.height <=> tmp.height AND  tb.special <=> tmp.special
               WHERE tmp.id > $limit_start AND tmp.id <= $limit_end
               ORDER BY  tmp.id  ASC 
               LIMIT $this->_limit_leght 
           ";
          $data = \DB::select($query);
          return $data;
      
     }  
       
     private function _create_table_tmp(){
          
          
          \Schema::create($this->_name_table_tmp, function ($table) {
                    $table->increments('id');
                    $table->string(config('const_db_tostem.db.product_selling_code_price.column.DESIGN'));
                    $table->string(config('const_db_tostem.db.product_selling_code_price.column.WIDTH'));
                    $table->string(config('const_db_tostem.db.product_selling_code_price.column.HEIGHT'));
                    $table->string(config('const_db_tostem.db.product_selling_code_price.column.SPECIAL'))->nullable();
                    $table->float(config('const_db_tostem.db.product_selling_code_price.column.AMOUNT'));
                    $table->index([config('const_db_tostem.db.product_selling_code_price.column.DESIGN'), config('const_db_tostem.db.product_selling_code_price.column.WIDTH'),config('const_db_tostem.db.product_selling_code_price.column.HEIGHT'),config('const_db_tostem.db.product_selling_code_price.column.SPECIAL')]);
          });

          
     }  
       
     private function _query_clone(){
          
          $col_conver = ','.config('const_db_tostem.db.product_selling_code_price.column.WIDTH').','.config('const_db_tostem.db.product_selling_code_price.column.HEIGHT');
          
           $query = "
                INSERT INTO ".$this->_object->getTable()." ( ".implode(', ', $this->_filltable).")
                SELECT  ".implode(', ', $this->_object->getColumnTmp())."$col_conver
                FROM      $this->_name_table_tmp
            ";
           return $query; 
      }

     private function _query_truncate(){
           $query = "TRUNCATE TABLE ".$this->_object->getTable().";";
           $this->_pdo->prepare($query)->execute(); 
      }


     private function _query_delete_tmp(){
           $query = "DROP  TABLE ". $this->_name_table_tmp.";";
           $this->_pdo->prepare($query)->execute(); 
      }
         
         

      
     
     /*
     
       public function gen_file_log_txt(){
            
            $count = $this->_length_data / $this->_limit_leght;
           
            for( $i = 1; $i <= ceil($count); $i++){
                 $limit = $i*$this->_limit_leght;
                 $data = $this->_query_export_data_t($limit);
                 $this->writte_file($data); 
                 unset($data);
            }
       }
       
       private function writte_file($data){
            
               $path_save = pathinfo($this->_path_file)['dirname'].'/'.$this->_nameLog_result;
            
               $myfile = fopen($path_save, "a+");
               foreach($data as $v ){
                       $txt = json_encode($v);
                       fwrite($myfile, $txt.PHP_EOL);
               }
               fclose($myfile);
       } 
 
    

       public function download($path){
            
           $path_txt  = pathinfo($this->_path_file)['dirname'].'/'.$this->_nameLog_result;
            
                       function cleanData(&$str)
           {
                    $str = preg_replace("/\t/", "\\t", $str);
                    $str = preg_replace("/\r?\n/", "\\n", $str);
                    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
            }
            $file = @fopen($path_txt, 'r');
               
           $filename = "website_data_" . date('Ymd') . ".xls";

           header("Content-Disposition: attachment; filename=\"$filename\"");
           header("Content-Type: application/vnd.ms-excel");
           
           $flag = false;

           while (!feof($file)) { 
                
           if(fgets($file) != ''){     
                 $row = json_decode(fgets($file),true);
                 if(!$flag) {
                   echo implode("\t", array_keys($row)) . "\n";
                   $flag = true;
                 }
                 array_walk($row, __NAMESPACE__ . '\cleanData');
                 echo implode("\t", array_values($row)) . "\n";
                 unset($row);
           }
           }
                  
           exit;
            
       }
     
     


          public function _insert_data_tmp_bk(){
         
          if(count($this->_data_sesulf) > 0){
               $this->_create_table_tmp();
                try {
                  
                   $data_chunk = array_chunk($this->_data_sesulf, $this->_limit_leght);
                   unset($this->_data_sesulf);
                   foreach ($data_chunk as $k => $data) {
                         $this->_pdo->prepare($this->_query_db($data))->execute();
                         unset($data_chunk[$k]);
                         //echo "used insert ".memory_get_usage() . '  <br>'  ; 
                    }
                  
                  unset($data_chunk);     
                  return TRUE;
              } catch (Exception $ex) {
                      return FALSE;
              }
           }
          return FALSE;
     }

      * 
      */
           
}