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
     
     protected $_filltable;

     protected $_datatable;
     
   
     
     
     
     public function __construct($object)
     {
         
           $this->_object = $object;
           $this->setFillTableM();
       
     }
     
     
     public function setFillTableM($param = []){
           if(count($param) == 0){
               $this->_filltable = $this->_object->getFillable();
           }else{
               $this->_filltable = $param;
           }
     }
     
     public function getFillTableM(){
           return $this->_filltable;   
     }


     

     

}
