<?php

namespace App\Services;

use App\Facades\MadoLog;
use Excel;
use Illuminate\Support\Facades\File;
/**
 * CSVの読み込み処理を提供するクラス
 */
class ExcelModelService 
{
     
     protected $_object;
     
     protected $_datatable;
     
     protected $_headerExcel = [];
     
     protected $_column_key = NULL;
     
     
     
     private     $_where = [];
     
     
     
     public function __construct($object)
     {
         
           $this->_object = $object;
     }
     
     
     public function setWhere($whereArray){
              $this->_where = $whereArray;
     }
     
     public function getWhere(){
          return $this->_where;
     }
     
     
     public function setHeaderExcel($arrHeader){
              $this->_headerExcel = $arrHeader;
     }
     
     public function getHeaderExcel(){
          return $this->_headerExcel;
     }
     
     public function setAutoIncrease($column_key_name){
              $this->_column_key = $column_key_name;
     }
     
     public function getAutoIncrease(){
          return $this->_column_key;
     }
     

}
