<?php
namespace App\Http\Controllers\Tostem\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tostem\{
              HisImportProductSellingCodePrice,
              ProductSellingCodePrice,
              OptionSellingCodePrice,
              GiestaSellingCodePrice       
     
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{
    DB,
    File
};
use App\Lib\ImportDataDb;
use Illuminate\Support\Facades\log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Services\ExcelService;
use Illuminate\Support\Facades\Artisan;

use CreateVProductPriceReferTable;
use CreateVProductPriceGiestaReferTable;

Class PriceMaintenanceController extends Controller
{

    public function __construct()
    {
         $this->middleware('auth');
    }

    public function index () {
         
       $_all_historys = HisImportProductSellingCodePrice::Getalldata();
       return view('tostem.admin.pmaintenance.index', compact('_all_historys'));
       
    }
    public function searchdata(Request $request) {
         
         $regEx = '/^\d{4}\/\d{2}\/\d{2}$/';
         
          $time_start = $request->time_start;
          
          $time_end = $request->time_end;
          
          if(!empty($time_start)){
               
               $check_date_start = preg_match($regEx,$time_start);
               if(!$check_date_start){
                   $return['status'] = 'error_time';
                   return $return;
               }
               
          }
          if(!empty($time_end)){
               
                $check_date_end = preg_match($regEx,$time_end);
                if(!$check_date_end){
                    $return['status'] = 'error_time';
                    return $return;
                }   
                
          }
          
          $_all_historys = HisImportProductSellingCodePrice::Searchdata($time_start,$time_end);
        
          $html = view('tostem.admin.pmaintenance.module-content.module-listhistory', compact('_all_historys'))->render();
          $return['html'] = $html;
          return $return; 
          
    }
    public function viewalldata() {
         
          $_all_historys = HisImportProductSellingCodePrice::Getalldata();
        
          $html = view('tostem.admin.pmaintenance.module-content.module-listhistory', compact('_all_historys'))->render();
          $return['html'] = $html;
          return $return; 
    }
    
    
    
    public function upload_file(Request $request) 
    {
         
        ini_set('max_execution_time', 0 );
        ini_set('request_terminate_timeout ', 0 );
        
        $_type_import = preg_replace('/[^0-9]/', '',$request->type);
        
        if(!isset($_type_import) || is_null($_type_import)){
             $return['status'] = 'NG';
             $return['msg'] = 'Please select Product or Option type !';
             return $return;
        }else{
             if($_type_import == ''){
                    $return['status'] = 'NG';
                    $return['msg'] = ' Select option type Invalid !';
                    return $return;
             }
        }
     
        $path_lock = base_path('storage/upload_tostem/pricemaintenance/lock_import');
        
        if(!HisImportProductSellingCodePrice::CheckSatus() || file_exists($path_lock)){
             $return['status'] = 'NG';
             $return['msg'] = 'Cannot import now, because another import is currently in progress. Try again after the current import task is over.';
             return $return;
        }
        \File::put($path_lock,'');
        
        
        $ext = [
                0 => 'xlsx',
            ];
        $return =[];
        
        $user = Auth::user();
        if ($request->hasFile('file')) {
            $file_upload = $request->file;
            $filename = $file_upload->getClientOriginalName();
            $baseName = pathinfo($filename,PATHINFO_FILENAME);
            $user_id = $user['id'];
            $ext_name = $file_upload->getClientOriginalExtension();
            if(in_array($ext_name,$ext) == true)
            {
                 
                try{
                         if(File::exists(base_path('storage/upload_tostem/pricemaintenance/tmp'))) 
                         {
                             File::deleteDirectory(base_path('storage/upload_tostem/pricemaintenance/tmp'));
                         }
                       
                         $file_upload = $file_upload->move(base_path('storage/upload_tostem/pricemaintenance/tmp'),$filename);

                         \File::copy(base_path('storage/upload_tostem/pricemaintenance/tmp/'.$filename),base_path('storage/upload_tostem/pricemaintenance/tmp/file_import.'.$ext_name));
                         
                        
                                 
                         $path_filenew =  storage_path().'/upload_tostem/pricemaintenance/tmp/file_import.'.$ext_name;
                         
                         if($_type_import == 0){
                              $excel = new ExcelService($path_filenew,new ProductSellingCodePrice);
                              $excel->setNamelog('product_selling_code_price');
                         }
                         if($_type_import == 1){
                              $excel = new ExcelService($path_filenew,new OptionSellingCodePrice);
                              $excel->setNamelog('option_selling_code_price');
                         }
                         
                         $file_txt_tmp = $excel->_gen_file_txt();
                   
                          if(!file_exists($file_txt_tmp)){
                                  $return['status'] = 'NG';
                                  $return['msg'] = 'System error, can not convert xlsx file to txt file. Contact your system administrator. ';
                                  File::delete($path_lock);
                                  if(File::exists(base_path('storage/upload_tostem/pricemaintenance/tmp')) == true ) {
                                       File::deleteDirectory(base_path('storage/upload_tostem/pricemaintenance/tmp'));
                                  }
                                  return $return;
                          }

                         $time_conver_tmp = date('Y_m_d_H_i_s');
                         $excel->setNametabletmp($time_conver_tmp);
                         $insert = $excel->_insert_data_tmp();
                         
                         if(isset($insert['status']) == true)
                         {
                             if(File::exists(base_path('storage/upload_tostem/pricemaintenance/tmp')) == true ) {
                                 File::deleteDirectory(base_path('storage/upload_tostem/pricemaintenance/tmp'));
                             }
                             File::delete($path_lock);
                             return $insert;
                         }

                         $check = $excel->_check_data_import();

                         if(count($check) != 0)
                         {
                             if(File::exists(base_path('storage/upload_tostem/pricemaintenance/tmp')) == true ) 
                             {
                                 File::deleteDirectory(base_path('storage/upload_tostem/pricemaintenance/tmp'));
                             }
                             File::delete($path_lock);
                             return $check;
                         }
                         
                         HisImportProductSellingCodePrice::create(
                             [
                                 config('const_db_tostem.db.history_import_product_selling_code_price.column.FILENAME') => $filename, 
                                 config('const_db_tostem.db.common_columns.column.ADD_USER_ID') => $user_id, 
                                 config('const_db_tostem.db.history_import_product_selling_code_price.column.STATUS') => '0',
                                 config('const_db_tostem.db.history_import_product_selling_code_price.column.OPTION') => $_type_import,
                                 config('const_db_tostem.db.common_columns.column.ADD_DATETIME') => $time_conver_tmp,
                                 config('const_db_tostem.db.common_columns.column.UPD_USER_ID') => $user_id, 
                                 config('const_db_tostem.db.common_columns.column.UPD_DATETIME') => $time_conver_tmp
                             ]
                         );
                         $data_history =  HisImportProductSellingCodePrice::select(config('const_db_tostem.db.history_import_product_selling_code_price.column.ID'),config('const_db_tostem.db.common_columns.column.ADD_DATETIME'))->orderBy(config('const_db_tostem.db.history_import_product_selling_code_price.column.ID'), 'desc')->limit(1)->get();
                         
                         $colum_id = config('const_db_tostem.db.history_import_product_selling_code_price.column.ID');
                         
                         $id =  $data_history[0]->$colum_id;
                         if(File::exists(base_path('storage/upload_tostem/pricemaintenance/'.$id))) 
                         {
                              File::deleteDirectory(base_path('storage/upload_tostem/pricemaintenance/'.$id));
                         }
                         File::makeDirectory(base_path('storage/upload_tostem/pricemaintenance/'.$id));

                         \File::copyDirectory(storage_path().'/upload_tostem/pricemaintenance/tmp/',base_path('storage/upload_tostem/pricemaintenance/'.$id.'/'));
                         if(File::exists(base_path('storage/upload_tostem/pricemaintenance/tmp')) == true ) 
                         {
                             File::deleteDirectory(base_path('storage/upload_tostem/pricemaintenance/tmp'));
                         }
                } catch (Exception $ex) {
                     
                     if(!empty($id)){
                           HisImportProductSellingCodePrice::UpdateStatus($id,6);
                     }
                     
                      if(File::exists(base_path('storage/upload_tostem/pricemaintenance/tmp')) == true ) 
                       {
                             File::deleteDirectory(base_path('storage/upload_tostem/pricemaintenance/tmp'));
                       }
                      File::delete($path_lock);
                       $return['status'] = 'NG';
                       $return['msg'] = 'System error, import failed !';
                     
                       return $return;
                }
                
                
            }else{
                    $return['status'] = 'NG';
                    $return['msg'] = 'Invalid format file type. Please select a xlsx file';
                    File::delete($path_lock);
                    return $return;
            }
         
           
        }
        if(file_exists(base_path('storage/upload_tostem/pricemaintenance/'.$id.'/'.$filename)) == true)
        {

           
           $path_storage = storage_path().'/upload_tostem/pricemaintenance/'.$id.'/';
           
           $path_filenew =  $path_storage.'file_import.'.$ext_name;
           
           $file_txt = $excel->_update_path($id);
           
           if(file_exists($file_txt) == true){
                
                try {
                     
                         $excel->setNamefile($baseName);
                         $excel->gen_file_log_excel();
                         if($_type_import == 0){
                              $excel->_insertDataDumy();
                         }
                         $excel->_insert_data();
                         

                          if($_type_import == 0){
                               
                                $model_giesta = new GiestaSellingCodePrice();
                                $model_giesta->CreateDataGiesta();

                                $create_table = new CreateVProductPriceReferTable();
                                $create_table->run(false);

                                $create_table_giesta = new CreateVProductPriceGiestaReferTable();
                                $create_table_giesta->run(false);
                          }
                          
                         
                         
                         $excel->setPathFile($path_storage.'InforUser.txt');
                         $excel->_wire_log_info_client();

                         Artisan::call('command:create-data-options-refer');

                         HisImportProductSellingCodePrice::UpdateStatus($id,9);
                         $return['status'] = 'OK';
                         $_all_historys = HisImportProductSellingCodePrice::Getalldata();
                         $html = view('tostem.admin.pmaintenance.module-content.module-listhistory', compact('_all_historys'))->render();
                         $return['html'] = $html;
                         $return['msg'] = 'Import Success ! ';
                         File::delete($path_lock);
                         return $return;
                     
                } catch (Exception $ex) {
                     
                        HisImportProductSellingCodePrice::UpdateStatus($id,6);
                        $_all_historys = HisImportProductSellingCodePrice::Getalldata();
                        $html = view('tostem.admin.pmaintenance.module-content.module-listhistory', compact('_all_historys'))->render();
                        $return['html'] = $html;
                        $return['status'] = 'NG';
                        $return['msg'] = 'System error, can not convert xlsx file to txt file. Contact your system administrator. ';
                        File::delete($path_lock);
                        return $return;
                }
                        
                         
                
           }else{
                    HisImportProductSellingCodePrice::UpdateStatus($id,6);
                    
                    $_all_historys = HisImportProductSellingCodePrice::Getalldata();
                    $html = view('tostem.admin.pmaintenance.module-content.module-listhistory', compact('_all_historys'))->render();
                    $return['html'] = $html;
                    $return['status'] = 'NG';
                    $return['msg'] = 'System error, can not convert xlsx file to txt file. Contact your system administrator. ';
                    File::delete($path_lock);
                    return $return;
           }
           
        }

          HisImportProductSellingCodePrice::UpdateStatus($id,6);
          $return['status'] = 'NG';
          $_all_historys = HisImportProductSellingCodePrice::Getalldata();
          $html = view('tostem.admin.pmaintenance.module-content.module-listhistory', compact('_all_historys'))->render();
          $return['html'] = $html;
          $return['msg'] = 'System error, upload file failed. ';
          File::delete($path_lock);
          return $return;
    }
    
    public function CheckdownloadFile(Request $request){
      
         
          $request->his_id;

          $request->key_download;

          $path  =  storage_path().'/upload_tostem/pricemaintenance/'.$request->his_id.'/';

          $file_name =  HisImportProductSellingCodePrice::select('filename')->where('id','=',$request->his_id)->limit(1)->get()[0]->filename;
      
          if($request->key_download == 1){
               $file_name = pathinfo($file_name)['filename'].'_result.'.pathinfo($file_name)['extension'];
               $path_full = $path.$file_name;
          }
          if($request->key_download == 0){
              
               $path_full = $path.$file_name;
          }
          
          if(file_exists($path_full)){
               $return['status'] = 'OK';
               $return['his_id'] = $request->his_id;
               $return['key_download'] = $request->key_download;
          }else{
               $return['status'] = 'NG';
          }
          return $return;
    }
    
    
    public function DownloadFile(Request $request){
      
         $request->his_id;
         
         $file_name =  HisImportProductSellingCodePrice::select('filename')->where('id','=',$request->his_id)->limit(1)->get()[0]->filename;
      
         $path  =  storage_path().'/upload_tostem/pricemaintenance/'.$request->his_id.'/';

         if($request->key_download == 1){
               $file_name = pathinfo($file_name)['filename'].'_result.'.pathinfo($file_name)['extension'];
               $path_full = $path.$file_name;
          }
          if($request->key_download == 0){
              
               $path_full = $path.$file_name;
          }
          
          return \Response::download($path_full);

    }
    public function downloadlog(Request $request){
        if(file_exists($request->path_file) == true)
        {
            return \Response::download($request->path_file)->deleteFileAfterSend(true); 
        }
    }
    public function upload_status(){
         $path_lock = base_path('storage/upload_tostem/pricemaintenance/lock_import');
         File::delete($path_lock);
         HisImportProductSellingCodePrice::UpdateStatuserrorall();
    }
    



}