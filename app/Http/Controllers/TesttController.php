<?php
namespace App\Http\Controllers;
use App\Facades\MadoLog;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Controllers\M_MailAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Excel;
use App\Models\Tostem\{
              HisImportProductSellingCodePrice,
              ProductSellingCodePrice,
              Quotation,
              GiestaSellingCodePrice
            
};
use App\Models\{
       CheckDataTmp        
};
use App\Services\ExcelService;
use App\Lib\ImportDataDb;
use Illuminate\Support\Facades\Artisan;
use Log;
use DB;
use App\Services\Generator;
use CreateVProductPriceReferTable;

class TesttController extends Controller {
     
    
     
    public function index() {
         
         
          $path = "/var/www/html/tostem_src/storage/testd/data-full-new2.xlsx";
          
          $model = new CheckDataTmp();
          
          
      
           $excel = new ExcelService($path,$model);
           
           
           //* insert data vào table tạm
           
           $excel->_gen_file_txt();
         
            $time_conver_tmp = '2020_03_17_15_59_15';
           $excel->setNametabletmp($time_conver_tmp);
           
           
           $excel->setNamefile('datasafterelete.xlsx');
           $excel->setHeaderExcel(
                   [
                        'Design'
                       ,'Width'
                       ,'Height'
                       ,'Special'
                       ,'Amount'
                   ]
                   );
           
           $excel->_insert_data_tmp();
           
           // end insert data vào table tạm
           
           
           
            
           //$excel->_check_and_update_data_read_file_excel(); // update or insert data new to table tmp - setup lại path
           //$excel->setNamefile('data.csv');
           //$excel->exportExcelToBrowser($model->_exportDataAdmin()); // export file data excel 
           
           //$excel->_check_excel();
           
         
           
           //$excel->setNamelog('product_selling_code_price');
          
          //$check = $excel->_check_data_import();
           
           //$excel->gen_file_log_excel();

           
           
               
           
    }
    
        public function download() {
         
             
           $model = new CheckDataTmp();
           
           $time_conver_tmp = '2020_03_17_15_59_15';
          
          
      
           $excel = new ExcelService('',$model);
           
           
           
           $excel->setNamefile('datasafterelete.xlsx');
           $excel->setHeaderExcel(
                   [
                        'Design'
                       ,'Width'
                       ,'Height'
                       ,'Special'
                       ,'Amount'
                   ]
                   );
           
             $excel->exportExcelToBrowser($model->_exportDataAdmin($time_conver_tmp)); // export file data excel 
    }
   
}