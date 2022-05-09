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
class ExcelService extends ExcelModelService {
    private $_pdo;
    public $_path_file;
    public $_gen_resulf;
    public $_data_sesulf = [];
    private $_namefile;
    private $_name_table_tmp;
    private $_length_data = 0;
    private $_limit_leght = 1000;
    private $_path_log_err;
    private $_path_log_excel;
    private $_path_file_txt;
    private $_name_sheet = 'data_result';
    private $_name_sheet_log;
    private $_ext = 'xlsx';
    private $_count_data_db = 0;
    public $columnDataExport = [];
    public function __construct($path_file, $object = []) {
        $this->_path_file = $path_file;
        if (isset(pathinfo($this->_path_file) ['extension'])) {
            $this->_ext = pathinfo($this->_path_file) ['extension'];
        }
        $this->_pdo = \DB::getPdo();
        if (is_object($object)) {
            parent::__construct($object);
        }
    }
    public function setPathFile($path) {
        $this->_path_file = $path;
    }
    public function _set_id_delete($list_id) {
        $this->_list_id_select = array_diff($this->_list_id_select, array_filter(array_column($list_id, 'stt'), function ($value) {
            return !is_null($value) && $value !== '';
        }));
        unset($list_id);
    }
    public function setNamelog($namefilelog) {
        $this->_name_sheet_log = $namefilelog;
    }
    public function setNamefile($namefile) {
        $this->_namefile = $namefile;
    }
    public function setNametabletmp($_time_now) {
        $this->_name_table_tmp = 'tbtmp_' . $_time_now;
    }
    public function setDatainsert($data) {
        $this->_data_sesulf = $data;
    }
    public function _gen_file_txt() {
        $import = new ImportDataDb;
        $this->_path_file_txt = $import->export_txt_flow_list_sheet($this->_path_file, 0, true);
        $this->_path_file = $this->_path_file_txt;
        return $this->_path_file_txt;
    }
    public function _update_path($his_id) {
        $this->_path_file = str_replace('/tmp/', '/' . $his_id . '/', $this->_path_file);
        return $this->_path_file;
    }
    public function _query_export_log($limit_end) {
        $limit_start = $limit_end - $this->_limit_leght;
        $query = "
                WITH RECURSIVE count_data AS
                    ( SELECT t1.*
                        FROM $this->_name_table_tmp AS t1
                        JOIN (SELECT design, height, width, special, COUNT(*)
                        FROM $this->_name_table_tmp 
                        GROUP BY design, height, width, special
                        HAVING count(*) > 1 ) t2 ON t2.design <=> t1.design AND t2.height <=> t1.height AND t2.width <=> t1.width AND t2.special <=> 	t1.special
                    ),
                    all_data_more_1_group_concat AS
                    (
                     select t1.design, t1.height, t1.width, t1.special, CONCAT('Design, Width, Height, Special must be unique. Duplicated rows: ',GROUP_CONCAT(id+1 order by id SEPARATOR', ')) as pos 
                        from count_data t1
                         GROUP BY t1.design, t1.height, t1.width,t1.special
                    ),
                    set_pos AS (
                        SELECT t1.*, t2.pos
                        FROM $this->_name_table_tmp AS t1
                        LEFT JOIN all_data_more_1_group_concat AS t2 ON t2.design <=> t1.design AND t2.height <=> t1.height AND t2.width <=> t1.width AND t2.special <=> t1.special 
                 ),
                set_pos_design AS (
                     	         SELECT t3.id, t3.design, t3.material, t3.glass_type, t3.glass_thickness 
                                FROM $this->_name_table_tmp as t3
                                GROUP BY t3.design, t3.material, t3.glass_type, t3.glass_thickness 
                                ORDER BY t3.id
                 ),
               post_resulf AS (
                       SELECT t2.*, CONCAT('Design, Material, Glass Type, Glass Thickness must be the same . Unduplicated rows ',GROUP_CONCAT(id+1 order by id SEPARATOR', ')) AS post_unduplicated
                              FROM set_pos_design as t2
                              GROUP BY t2.design
                              HAVING COUNT(*)>1    
                ),
                 set_pos_unduplicated AS (
                     SELECT t2.id, t3.post_unduplicated
                     FROM set_pos_design as t2
                     LEFT JOIN post_resulf  AS  t3 ON t3.design <=> t2.design
                ),
                set_name as (
                SELECT id ,
                            CASE
                                WHEN coalesce(design, '') = '' THEN CONCAT('A',id+1)
                            END as design,
                            CASE
                                WHEN coalesce(amount, '') = '' THEN CONCAT('E',id+1)
                            END as amount
                FROM set_pos
                ),
                resule_table as (
                         SELECT tmp.*, tmp2.post_unduplicated, CONCAT('Cell ',NULLIF(CONCAT_WS(', ',na.design,na.amount),''),' is required') as cell_null,
                         CASE   WHEN concat('',tmp.amount * 1) <> tmp.amount  THEN CONCAT('Column Amount: ','E',na.id+1,' Invalid format value')  END as cell_text
                         FROM set_name as na 
                         right join set_pos as tmp on na.id = tmp.id
                         LEFT join set_pos_unduplicated as tmp2 on na.id = tmp2.id
                )
                
                SELECT design,width,height,special,amount, material, glass_type, glass_thickness,NULL AS col,CONCAT_WS('\n',cell_null, pos, cell_text, post_unduplicated) as error
                FROM resule_table
                WHERE id > $limit_start AND id <= $limit_end
                LIMIT $this->_limit_leght";
        
        $statement = $this->_pdo->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
       
        return $result;
    }
    public function _check_data_import() {
        $return = [];
        $name_result = 'error_log_' . date('hhmmss') . '.' . $this->_ext;
        $this->_path_log_err = base_path('storage/upload_tostem/pricemaintenance/') . $name_result;
        $writer = WriterFactory::create(Type::XLSX);
        $writer->openToFile($this->_path_log_err);
        $writer->getCurrentSheet()->setName($this->_name_sheet_log);
        $writer->addRows([$this->_object->getColumnLog() ]);
        $count = ceil($this->_length_data / $this->_limit_leght);
        $flg = 'done';
        \DB::statement("SET SQL_MODE=''");
        for ($i = 1;$i <= $count;$i++) {
            $limit = $i * $this->_limit_leght;
            $data = $this->_query_export_log($limit);
            // $data = json_decode(json_encode($data),true);
            if ($flg == 'done') {
                foreach ($data as $key => $value) {
                    if ($value['error'] != null) {
                        $flg = 'err';
                    }
                }
            }
            $writer->addRows($data);
            unset($data);
        }
        $writer->close();
        \DB::statement("SET SQL_MODE=only_full_group_by");
        
        if ($flg == 'err') {
            $return['status'] = 'err_data';
            $return['path_file'] = $this->_path_log_err;
            $this->_query_delete_tmp();
            return $return;
        }
        File::delete($this->_path_log_err);
        return $return;
    }
    public function _insert_data_tmp() {
        try {
            $this->_create_table_tmp();
            $file = @fopen($this->_path_file, 'r');
            $i = 0;
            while (!feof($file)) {
                $row = fgets($file);
                if ($i == 0) {
                    $columns = array_map('strtolower', explode("_\\t,", str_replace(" ", '_', trim($row))));
                    $column_db = $this->_object->getColumnTmp();
                    
                    if(count($columns) != count($column_db)){
                              $return['status'] = 'err_column';
                              $this->_query_delete_tmp();
                              return $return;
                    }else{
                         foreach ($columns as $key => $value) {
                             if (!isset($column_db[$key]) || $value != $column_db[$key]) {
                                 $return['status'] = 'err_column';
                                 $this->_query_delete_tmp();
                                 return $return;
                             }
                         }
                    }
                }
                if ($i > 0) {
                    if ($row != '') {
                        $this->_data_sesulf[] = $this->_generate_columndb_value(explode("_\\t,", trim($row)), $columns);
                    }
                }
                if (count($this->_data_sesulf) > 0 && (count($this->_data_sesulf) == $this->_limit_leght)) {
                    $this->_pdo->prepare($this->_query_db($this->_data_sesulf))->execute();
                    $this->_length_data+= count($this->_data_sesulf);
                    $this->_data_sesulf = NULL;
                }
                $i++;
            }
            if (is_array($this->_data_sesulf) && count($this->_data_sesulf) > 0) {
                $this->_pdo->prepare($this->_query_db($this->_data_sesulf))->execute();
                $this->_length_data+= count($this->_data_sesulf);
                $this->_data_sesulf = NULL;
            }
            return true;
        }
        catch(Exception $ex) {
            $this->_query_delete_tmp();
            return false;
        }
        return false;
    }
    public function _insert_data() {
        try {
            \DB::beginTransaction();
            $this->_query_truncate();
            $this->_pdo->prepare($this->_query_clone())->execute();
            $this->_query_delete_tmp();
            \DB::commit();
            return true;
        }
        catch(Exception $ex) {
            $this->_query_delete_tmp();
            return false;
        }
    }
    public function gen_file_log_excel() {
        $name_result = $this->_namefile . '_result.' . $this->_ext;
        $this->_path_log_excel = pathinfo($this->_path_file) ['dirname'] . '/' . $name_result;
        $writer = WriterFactory::create(Type::XLSX);
        $writer->openToFile($this->_path_log_excel);
        $writer->getCurrentSheet()->setName($this->_name_sheet);
        $writer->addRows([$this->_object->getColumnExport() ]);
        $count = ceil($this->_length_data / $this->_limit_leght);
        //Log::debug('length data '.$this->_length_data);
        for ($i = 1;$i <= $count;$i++) {
            $limit = $i * $this->_limit_leght;
            $data = $this->_query_export_data($limit);
            $data = json_decode(json_encode($data), true);
            $writer->addRows($data);
            unset($data);
        }
        $this->setCountdatadb();
        $count_delete = ceil($this->_count_data_db / $this->_limit_leght);
        for ($j = 1;$j <= $count_delete;$j++) {
            $limit_delete = $j * $this->_limit_leght;
            $data_delete = $this->_query_export_data_delete($limit_delete);
            if (count($data_delete) > 0) {
                $data_delete = json_decode(json_encode($data_delete), true);
                $writer->addRows($data_delete);
            }
            unset($data_delete);
        }
        $writer->close();
    }
    private function _generate_columndb_value($data, $columns) {
        $count_column = count($columns);
        $result = [];
        $data_trim = [];
        foreach ($data as $key => $value) {
            $data_trim[] = trim($value);
        }
        $count_data = count($data_trim);
        if ($count_data === $count_column) {
            $result = array_combine($columns, $data_trim);
        } else {
            for ($i = 0;$i < $count_data - $count_column;$i++) {
                unset($data_trim[$count_data - $i - 1]);
            }
            $result = array_combine($columns, $data_trim);
        }
        return $result;
    }
    private function _query_db($data) {
        $value = '';
        $max_count = count($data) - 1;
        $max_count_col = count($this->_object->getColumnTmp()) - 1;
        foreach ($data as $k => $v) {
            $val = '(';
            foreach ($this->_object->getColumnTmp() as $kt => $f) {
                if ($f != config('const_db_tostem.db.product_selling_code_price.column.AMOUNT')) {
                    if ($v[$f] == '' || is_null($v[$f])) {
                        $v[$f] = 'NULL';
                    } else {
                        $v[$f] = \DB::connection()->getPdo()->quote(trim($v[$f]));
                    }
                } else {
                    if ($v[$f] == '' || is_null($v[$f])) {
                        $v[$f] = 'NULL';
                    } else {
                        $check_number = $this->_check_type_number(trim($v[$f]));
                        if ($check_number) {
                            $v[$f] = \DB::connection()->getPdo()->quote($this->tofloat($v[$f]));
                        } else {
                            $v[$f] = \DB::connection()->getPdo()->quote(trim($v[$f]));
                        }
                    }
                }
                if ($kt < $max_count_col) {
                    $val.= $v[$f] . ',';
                }
                if ($kt == $max_count_col) {
                    $val.= $v[$f];
                }
            }
            if ($k < $max_count) {
                $value.= $val . '),';
            }
            if ($k == $max_count) {
                $value.= $val . ')';
            }
            $val = '';
        }
        //$placeHolders = '(' . implode(', ', array_fill(0, count($this->_filltable), '?')) . ')';
        $query = "INSERT INTO " . $this->_name_table_tmp . " (" . implode(', ', $this->_object->getColumnTmp()) . ") VALUES $value";
        unset($value);
        return $query;
    }
    private function _query_export_data_delete($limit_end) {
        $limit_start = $limit_end - $this->_limit_leght;
        $query = "
               SELECT tb.design, tb.width_org, tb.height_org, tb.special, tb.amount, tb.material, tb.glass_type, tb.glass_thickness, NULL AS col,'Deleted' AS status
               FROM " . $this->_object->getTable() . "  AS tb
               LEFT JOIN $this->_name_table_tmp  AS tmp ON tb.design <=> tmp.design  AND  tb.width_org <=> tmp.width  AND  tb.height_org <=> tmp.height AND  tb.special <=> tmp.special
               WHERE tb." . $this->_object->getKeyName() . " > $limit_start AND tb." . $this->_object->getKeyName() . " <= $limit_end  AND  tmp.id IS  NULL AND tb.design != 'no_selling_code'
               LIMIT $this->_limit_leght;    
           ";
        $data = \DB::select($query);
        return $data;
    }
    private function _query_export_data($limit_end) {
        $limit_start = $limit_end - $this->_limit_leght;
        $query = "
               SELECT tmp.design, tmp.width, tmp.height, tmp.special, tmp.amount, tmp.material, tmp.glass_type, tmp.glass_thickness, NULL AS col,
               CASE
                    WHEN  tb.amount IS NULL  THEN 'New'
                    WHEN  tmp.amount <=> tb.amount AND tmp.material <=> tb.material AND tmp.glass_type <=> tb.glass_type AND tmp.glass_thickness <=> tb.glass_thickness  THEN 'Same'
                    WHEN  tmp.amount <> tb.amount OR CONCAT_WS(',', tmp.material, tmp.glass_type, tmp.glass_thickness)  != CONCAT_WS(',', tb.material, tb.glass_type, tb.glass_thickness) THEN 'Updated'
                END
                AS status

               FROM $this->_name_table_tmp AS tmp
               LEFT JOIN " . $this->_object->getTable() . " AS tb ON tb.design <=> tmp.design  AND  tb.width_org <=> tmp.width  AND  tb.height_org <=> tmp.height AND  tb.special <=> tmp.special
               WHERE tmp.id > $limit_start AND tmp.id <= $limit_end
               LIMIT $this->_limit_leght;
           ";
        $data = \DB::select($query);
        return $data;
    }
    private function _create_table_tmp() {
        \Schema::create($this->_name_table_tmp, function ($table) {
            $table->increments('id');
            $table->string(config('const_db_tostem.db.product_selling_code_price.column.DESIGN'), 50)->nullable();
            $table->string(config('const_db_tostem.db.product_selling_code_price.column.WIDTH'), 50)->nullable();
            $table->string(config('const_db_tostem.db.product_selling_code_price.column.HEIGHT'), 50)->nullable();
            $table->string(config('const_db_tostem.db.product_selling_code_price.column.SPECIAL'), 50)->nullable();
            $table->string(config('const_db_tostem.db.product_selling_code_price.column.AMOUNT'))->nullable();
            $table->string(config('const_db_tostem.db.product_selling_code_price.column.MATERIAL'), 50)->nullable();
            $table->string(config('const_db_tostem.db.product_selling_code_price.column.GLASS_TYPE'), 50)->nullable();
            $table->string(config('const_db_tostem.db.product_selling_code_price.column.GLASS_THICKNESS'), 50)->nullable();
            $table->index([config('const_db_tostem.db.product_selling_code_price.column.DESIGN'), config('const_db_tostem.db.product_selling_code_price.column.WIDTH'), config('const_db_tostem.db.product_selling_code_price.column.HEIGHT'), config('const_db_tostem.db.product_selling_code_price.column.SPECIAL') ], 'index_price_key1');
            $table->index([config('const_db_tostem.db.product_selling_code_price.column.DESIGN'), config('const_db_tostem.db.product_selling_code_price.column.MATERIAL'), config('const_db_tostem.db.product_selling_code_price.column.GLASS_TYPE'), config('const_db_tostem.db.product_selling_code_price.column.GLASS_THICKNESS') ], 'index_price_key2');
            //$table->index(config('const_db_tostem.db.product_selling_code_price.column.AMOUNT'));
            
        });
    }
    private function setCountdatadb() {
        $query = "SELECT COUNT(" . $this->_object->getKeyName() . ") AS count FROM  " . $this->_object->getTable() . "";
        $this->_count_data_db = \DB::select($query) [0]->count;
    }
    private function _query_clone() {
        //$col_conver = ','.config('const_db_tostem.db.product_selling_code_price.column.WIDTH').','.config('const_db_tostem.db.product_selling_code_price.column.HEIGHT');
        $array_column_import = $this->_object->getColumnTmp();
        array_splice($array_column_import, 5, 0, config('const_db_tostem.db.product_selling_code_price.column.WIDTH'));
        array_splice($array_column_import, 6, 0, config('const_db_tostem.db.product_selling_code_price.column.HEIGHT'));
        $query = "
                INSERT INTO " . $this->_object->getTable() . " ( " . implode(', ', $this->_object->getFillable()) . ")
                SELECT  " . implode(', ', $array_column_import) . "
                FROM      $this->_name_table_tmp
            ";
        return $query;
    }
    public function _query_truncate() {
        $query = "TRUNCATE TABLE " . $this->_object->getTable() . ";";
        $this->_pdo->prepare($query)->execute();
    }
    private function _query_delete_tmp() {
        $query = "DROP  TABLE " . $this->_name_table_tmp . ";";
        $this->_pdo->prepare($query)->execute();
    }
    private function tofloat($num) {
        $dotPos = strrpos($num, '.');
        $commaPos = strrpos($num, ',');
        $sep = (($dotPos > $commaPos) && $dotPos) ? $dotPos : ((($commaPos > $dotPos) && $commaPos) ? $commaPos : false);
        if (!$sep) {
            return floatval(preg_replace("/[^0-9]/", "", $num));
        }
        return floatval(preg_replace("/[^0-9]/", "", substr($num, 0, $sep)) . '.' . preg_replace("/[^0-9]/", "", substr($num, $sep + 1, strlen($num))));
    }
    private function _check_type_number($value) {
        $value = trim($value);
        $dotPos = strrpos($value, '.');
        $commaPos = strrpos($value, ',');
        $sep = (($dotPos > $commaPos) && $dotPos) ? $dotPos : ((($commaPos > $dotPos) && $commaPos) ? $commaPos : false);
        if ($sep !== false) {
            $value = str_replace([',', '.'], "", $value);
        }
        if (preg_match('/^[0-9]+$/', $value)) {
            return true;
        }
        return false;
    }
    public function _exportCsvToBrowser() {
        $writer = WriterFactory::create(Type::CSV);
        $writer->openToBrowser($this->_namefile);
        // add header
        $writer->addRows([$this->getHeaderExcel() ]);
        // end add header
        $this->_object->_query->chunk($this->_limit_leght, function ($datas) use ($writer) {
            if ($datas->count() > 0) {
                $datas = json_decode(json_encode($datas->toArray()), true);
                foreach ($datas as $v) {
                    if (!empty($this->_column_key)) {
                        $this->_length_data+= 1;
                        $v[$this->_column_key] = $this->_length_data;
                    }
                    if (property_exists($this->_object, 'convertData')){
                         $v = $this->_object->conVertData($v);
                    } 

                    if (
                        !empty($v) &&
                        !empty($this->columnDataExport) &&
                        is_array($this->columnDataExport)
                    ) {
                        foreach ($v as $v_key => $v_value) {
                            if (!in_array($v_key, $this->columnDataExport)) {
                                unset($v[$v_key]);
                            }
                        }
                    }
                 
                    $writer->addRow($v);
                }
            }
            unset($datas);
        });
        $writer->close();
    }
    public function _exportCsvToStorage() {
        if (!empty($this->_path_file) && is_null($this->_path_file) || $this->_path_file == '') {
            $this->_path_file = storage_path('tmp/exportcsv/');
            if (!File::exists($this->_path_file)) {
                File::makeDirectory($this->_path_file);
            }
            $file_name = \Str::random(30) . date('YmdHis') . '.csv';
            $this->_path_file = $this->_path_file . $file_name;
        }
        $writer = WriterFactory::create(Type::CSV);
        $writer->openToFile($this->_path_file);
        // add header
        $writer->addRows([$this->getHeaderExcel() ]);
        // end add header
        $this->_object->_query->chunk($this->_limit_leght, function ($datas) use ($writer) {
            if ($datas->count() > 0) {
                $datas = json_decode(json_encode($datas->toArray()), true);
                foreach ($datas as $v) {
                    if (!empty($this->_column_key)) {
                        $this->_length_data+= 1;
                        $v[$this->_column_key] = $this->_length_data;
                    }
                    $writer->addRow($v);
                }
            }
            unset($datas);
        });
        $writer->close();
        return $this->_path_file;
    }
    // FN export data for Quotation PRIVATE
    public function _exportCsvPrivate($param_where) {
        $this->_object->setTypeSelect(1);
        $this->_object->_exportDataFrontend($param_where);
        $this->setHeaderExcel(array_keys($this->_object->getColumnExport()));
        $this->setAutoIncrease('stt');
        $this->_exportCsvToStorage();
        return $this->_path_file;
    }
    // end FN export data for Quotation PRIVATE
    public function insertData_fromExcel() {
        try {
            $reader = ReaderFactory::create(Type::XLSX);
            $reader->setShouldFormatDates(true);
            $reader->open($this->_path_file);
            foreach ($reader->getSheetIterator() as $k => $sheet) {
                if ($k == 1) {
                    foreach ($sheet->getRowIterator() as $i => $row) {
                        if ($i == 1) {
                            $columns = array_map('strtolower', $row);
                        }
                        if ($i > 1) {
                            if (count($row) > 0) {
                                $this->_data_sesulf[] = $this->_generate_columndb_value($row, $columns);
                            }
                        }
                        if (count($this->_data_sesulf) > 0 && (count($this->_data_sesulf) == $this->_limit_leght)) {
                            $this->_pdo->prepare($this->_query_db_with_excel($this->_data_sesulf))->execute();
                            $this->_length_data+= count($this->_data_sesulf);
                            $this->_data_sesulf = NULL;
                        }
                    }
                    if (is_array($this->_data_sesulf) && count($this->_data_sesulf) > 0) {
                        $this->_pdo->prepare($this->_query_db_with_excel($this->_data_sesulf))->execute();
                        $this->_length_data+= count($this->_data_sesulf);
                        $this->_data_sesulf = NULL;
                    }
                }
            }
            $reader->close();
            return true;
        }
        catch(Exception $ex) {
            $this->_query_delete_tmp();
            return false;
        }
        return false;
    }
    public function _insertDataDumy(){
         $data_dumy = [
             [
                  'design' => 'no_selling_code'
                 ,'width' => NULL
                 ,'height' => NULL
                 ,'special' => NULL
                 ,'amount' => '0'
                 ,'width_org' => NULL
                 ,'height_org' => NULL
                 ,'material' => NULL
                 ,'glass_type' => NULL
                 ,'glass_thickness' => NULL  
             ]
         ];
         $this->_pdo->prepare($this->_query_db($data_dumy))->execute();
    }
    private function _query_db_with_excel($data) {
        $value = '';
        $max_count = count($data) - 1;
        $max_count_col = count($this->_object->getColumnTmp()) - 1;
        foreach ($data as $k => $v) {
            $val = '(';
            foreach ($this->_object->getColumnTmp() as $kt => $f) {
                if ($v[$f] == '' || is_null($v[$f])) {
                    $v[$f] = 'NULL';
                } else {
                    $v[$f] = "'" . $v[$f] . "'";
                }
                if ($kt < $max_count_col) {
                    $val.= $v[$f] . ',';
                }
                if ($kt == $max_count_col) {
                    $val.= $v[$f];
                }
            }
            if ($k < $max_count) {
                $value.= $val . '),';
            }
            if ($k == $max_count) {
                $value.= $val . ')';
            }
            $val = '';
        }
        //$placeHolders = '(' . implode(', ', array_fill(0, count($this->_filltable), '?')) . ')';
        $query = "INSERT INTO " . $this->_object->getTable() . " (" . implode(', ', $this->_object->getColumnTmp()) . ") VALUES $value";
        unset($value);
        return $query;
    }
    public function _wire_log_info_client() {
        $infor_header = getallheaders();
        $myfile = fopen($this->_path_file, "a+");
        if (count($infor_header) > 0) {
            foreach ($infor_header as $k => $info) {
                $data = '[ ' . $k . '] : ' . $info;
                fwrite($myfile, $data . PHP_EOL);
            }
        }
        $ip_client = 'IP User Client : ' . $this->get_client_ip();
        fwrite($myfile, $ip_client . PHP_EOL);
        fclose($myfile);
    }
    private function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP')) $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR')) $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED')) $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR')) $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED')) $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR')) $ipaddress = getenv('REMOTE_ADDR');
        else $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
    // CODE PRIVATE TEST
    public function exportExcelToBrowser() {
        if (!empty($this->_path_file) && is_null($this->_path_file) || $this->_path_file == '') {
            $this->_path_file = storage_path('tmp/exportcsv/');
            if (!File::exists($this->_path_file)) {
                File::makeDirectory($this->_path_file);
            }
            $file_name = \Str::random(30) . date('YmdHis') . '.xlsx';
            $this->_path_file = $this->_path_file . $file_name;
        }
        $writer = WriterFactory::create(Type::XLSX);
        $writer->openToFile($this->_path_file);
        // add header
        $writer->addRows([$this->getHeaderExcel() ]);
        // end add header
        $this->_object->_query->chunk($this->_limit_leght, function ($datas) use ($writer) {
            foreach ($datas as $k => $v) {
                $v = json_decode(json_encode($v), true);
                if (!empty($this->_column_key)) {
                    $this->_length_data+= 1;
                    $v[$this->_column_key] = $this->_length_data;
                }
                $data[] = "" . $v['design'] . "";
                $data[] = "" . $v['width'] . "";
                $data[] = "" . $v['height'] . "";
                $data[] = "" . $v['special'] . "";
                $data[] = $v['amount'];
                $writer->addRow($data);
                $data = [];
                unset($datas[$k]);
            }
        });
        $writer->close();
        var_dump($this->_path_file);
    }
    public function exportDataViewProduct() {
        if (!empty($this->_path_file) && is_null($this->_path_file) || $this->_path_file == '') {
            $this->_path_file = storage_path('tmp/exportcsv/');
            if (!File::exists($this->_path_file)) {
                File::makeDirectory($this->_path_file);
            }
            $file_name = \Str::random(30) . date('YmdHis') . '.xlsx';
            $this->_path_file = $this->_path_file . $file_name;
        }
        $writer = WriterFactory::create(Type::XLSX);
        $writer->openToFile($this->_path_file);
        // add header
        $writer->addRows([$this->getHeaderExcel() ]);
        // end add header
        $this->_object->_query->chunk($this->_limit_leght, function ($datas) use ($writer) {
            foreach ($datas as $k => $v) {
                $v = json_decode(json_encode($v), true);
                if (!empty($this->_column_key)) {
                    $this->_length_data+= 1;
                    $v[$this->_column_key] = $this->_length_data;
                }
                $data[] = "" . $v['design'] . "";
                $data[] = "" . $v['width'] . "";
                $data[] = "" . $v['height'] . "";
                $data[] = "" . $v['special'] . "";
                $data[] = $v['amount'];
                $writer->addRow($data);
                $data = [];
                unset($datas[$k]);
            }
        });
        $this->_object->_query_2->chunk($this->_limit_leght, function ($datas) use ($writer) {
            foreach ($datas as $k => $v) {
                $v = json_decode(json_encode($v), true);
                if (!empty($this->_column_key)) {
                    $this->_length_data+= 1;
                    $v[$this->_column_key] = $this->_length_data;
                }
                $data[] = "" . $v['design'] . "";
                $data[] = "" . $v['width'] . "";
                $data[] = "" . $v['height'] . "";
                $data[] = "" . $v['special'] . "";
                $data[] = $v['amount'];
                $writer->addRow($data);
                $data = [];
                unset($datas[$k]);
            }
        });
        $writer->close();
        var_dump($this->_path_file);
    }
    public function _check_and_update_data_read_file_excel() {
        try {
            $reader = ReaderFactory::create(Type::XLSX);
            $reader->setShouldFormatDates(true);
            $reader->open($this->_path_file);
            $data_update = [];
            $data_new = [];
            $data_same = [];
            foreach ($reader->getSheetIterator() as $k => $sheet) {
                if ($k == 1) {
                    foreach ($sheet->getRowIterator() as $i => $row) {
                        if ($i == 1) {
                            $columns = array_map('strtolower', $row);
                            $column_db = $this->_object->getColumnTmp();
                        }
                        if ($i > 1) {
                            if (count($row) > 0) {
                                $data = $this->_generate_columndb_value($row, $columns);
                                $check = $this->_query_check_data($data);
                                if ($check == 'update') {
                                    $this->_query_update_data($data);
                                    $data_update[$i] = $data;
                                } else if ($check == 'new') {
                                    $this->_query_insert_data($data);
                                    $data_new[$i] = $data;
                                } else {
                                    $data_same[$i] = $data;
                                }
                                unset($data);
                            }
                        }
                    }
                }
            }
            $reader->close();
            echo "data update<pre>";
            echo "<pre>";
            print_r("count data update" . count($data_update));
            echo "<pre>";
            echo "data new<pre>";
            echo "<pre>";
            print_r("count data new" . count($data_new));
            echo "<pre>";
            echo "data same<pre>";
            echo "<pre>";
            print_r("count data same" . count($data_same));
            echo "<pre>";
            //$this->exportCsvToBrowser($data_new);
            return true;
        }
        catch(Exception $ex) {
            return false;
        }
        return false;
    }
    private function _query_update_data($data) {
        if (!empty($data['amount'])) {
            $where = "";
            if (isset($data['design'])) {
                if ($data['design'] != '') {
                    $where.= " AND design <=> '" . $data['design'] . "'";
                } else {
                    $where.= " AND design <=> NULL";
                }
            }
            if (isset($data['width'])) {
                if ($data['width'] != '') {
                    $where.= " AND width <=> '" . $data['width'] . "'";;
                } else {
                    $where.= " AND width <=> NULL";
                }
            }
            if (isset($data['height'])) {
                if ($data['height'] != '') {
                    $where.= " AND height <=> '" . $data['height'] . "'";;
                } else {
                    $where.= " AND height <=> NULL";
                }
            }
            if (isset($data['special'])) {
                if ($data['special'] != '') {
                    $where.= " AND special <=> '" . $data['special'] . "'";;
                } else {
                    $where.= " AND special <=> NULL";
                }
            }
            $query = "
                        UPDATE $this->_name_table_tmp
                        SET amount = " . $data['amount'] . "
                        WHERE 1 = 1  " . $where . "
                    ";
            $this->_pdo->prepare($query)->execute();
        }
    }
    private function _query_insert_data($data) {
        if (!empty($data['amount'])) {
            $where = "";
            if (isset($data['design'])) {
                if ($data['design'] == '') {
                    $data['design'] = "NULL";
                }
            }
            if (isset($data['width'])) {
                if ($data['width'] == '') {
                    $data['width'] = "NULL";
                }
            }
            if (isset($data['height'])) {
                if ($data['height'] == '') {
                    $data['height'] = "NULL";
                }
            }
            if (isset($data['special'])) {
                if ($data['special'] == '') {
                    $data['special'] = "NULL";
                }
            }
            $value = "('" . $data['design'] . "','" . $data['width'] . "','" . $data['height'] . "','" . $data['special'] . "','" . $data['amount'] . "')";
            $query = "INSERT INTO " . $this->_name_table_tmp . " (" . implode(', ', $this->_object->getColumnTmp()) . ") VALUES $value";
            $this->_pdo->prepare($query)->execute();
        }
    }
    private function _query_check_data($data) {
        if (!empty($data['amount'])) {
            $where = "";
            if (isset($data['design'])) {
                if ($data['design'] != '') {
                    $where.= " AND design <=> '" . $data['design'] . "'";
                } else {
                    $where.= " AND design <=> NULL";
                }
            }
            if (isset($data['width'])) {
                if ($data['width'] != '') {
                    $where.= " AND width <=> '" . $data['width'] . "'";;
                } else {
                    $where.= " AND width <=> NULL";
                }
            }
            if (isset($data['height'])) {
                if ($data['height'] != '') {
                    $where.= " AND height <=> '" . $data['height'] . "'";;
                } else {
                    $where.= " AND height <=> NULL";
                }
            }
            if (isset($data['special'])) {
                if ($data['special'] != '') {
                    $where.= " AND special <=> '" . $data['special'] . "'";
                } else {
                    $where.= " AND special <=> NULL";
                }
            }
            $query = "
                        SELECT *
                        FROM $this->_name_table_tmp
                        WHERE 1 = 1  " . $where . "
                    ";
            $statement = $this->_pdo->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            if (count($result) > 0) {
                if ($result[0]['amount'] == $data['amount']) {
                    return 'same';
                }
                return 'update';
            }
            return 'new';
        }
    }
    public function _check_excel() {
        try {
            $datas = [];
            $check_selling_code = [];
            $reader = ReaderFactory::create(Type::XLSX);
            $reader->setShouldFormatDates(true);
            $reader->open($this->_path_file);
            $datas_p = [];
            foreach ($reader->getSheetIterator() as $k => $sheet) {
                if ($k == 1) {
                    foreach ($sheet->getRowIterator() as $i => $row) {
                        if ($i == 1) {
                            $columns = array_map('strtolower', $row);
                            $column_db = $this->_object->getColumnTmp();
                        }
                        if ($i > 1) {
                            if (count($row) > 0) {
                                $data = $this->_generate_columndb_value($row, $columns);
                                $check_selling_code[$data['design']] = $i;
                                $key = $data['design'] . '-' . $data['width'] . '-' . $data['height'] . '-' . $data['special'];
                                if (isset($datas[$key])) {
                                    $datas_p[$key] = $datas[$key];
                                    $datas_p[$key][] = $data['amount'];
                                }
                                $datas[$key][] = $data['amount'];
                                unset($data);
                            }
                        }
                    }
                }
            }
            echo "<pre>";
            print_r($datas_p);
            echo "<pre>";
            $reader->close();
            return true;
        }
        catch(Exception $ex) {
            return false;
        }
        return false;
    }
    public function setColumnDataExport($columnDataExport)
    {
        $this->columnDataExport = $columnDataExport;
    }
    /*
      * 
      * 
      * 
      *     public function test_gen_file_log(){
         
           $style = (new StyleBuilder())
          ->setShouldWrapText()
          ->build();
    
           
           $name_result = 'test_result.'.$this->_ext;
           
           $this->_path_log_excel = pathinfo($this->_path_file)['dirname'].'/'.$name_result;
           
           
           $writer = WriterFactory::create(Type::XLSX);
           $writer->openToFile($this->_path_log_excel);
           $writer->getCurrentSheet()->setName($this->_name_sheet);
           
           $row = [
               'a' => 'demo test \n test',
               'b' => 'demo test \r test',
           ];
           
           $writer->addRowsWithStyle([$row],$style);
           
    
          
          $writer->close();
            
       }
    
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
    // END CODE PRIVATE TEST
    
}
