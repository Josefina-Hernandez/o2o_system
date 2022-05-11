<?php
namespace App\Http\Controllers\Tostem\Admin;

use App\Http\Controllers\Controller;

use App\Models\Tostem\{
              TDataConvertUpdateDataGiesta,
              GiestaSellingCodePrice
};


use App\Services\ExcelService;


class CommonController extends Controller {
     
    
     
    public function index() {
         
        
               
           
    }
    public function genTableContentUpdataGiesta() {
         
         
        
          $path = storage_path().'/upload_tostem/filedataupdategiesta/filedata_spec_update_giesta.xlsx';

          $model = new TDataConvertUpdateDataGiesta();
         
         
          $excel = new ExcelService($path,$model);
          try {
                    $excel->_query_truncate();
                    $excel->insertData_fromExcel();
                    echo "done";
          } catch (Exception $ex) {
                    echo "error".$ex;
          }
         
    }
    
    public function updateDataGiesta(){
         try {
                    $model_giesta = new GiestaSellingCodePrice();
                    $model_giesta->CreateDataGiesta();
                    echo "done";
          } catch (Exception $ex) {
                    echo "error".$ex;
          }
         
          
    } 
   
}