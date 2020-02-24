<?php
namespace App\Http\Controllers\Tostem\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tostem\{
              HisImportProductSellingCodePrice,
              ProductSellingCodePrice
     
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
         
          $time_start = $request->time_start;
          
          $time_end = $request->time_end;
          
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
        
        $path_lock = base_path('storage/upload_tostem/pricemaintenance/lock_import');
        
        if(!HisImportProductSellingCodePrice::CheckSatus() || file_exists($path_lock)){
             $return['status'] = 'NG';
             $return['msg'] = 'Cannot import now, because another import is currently in progress. Try again after the current import task is over.';
             return $return;
        }
        \File::put($path_lock,'');
        
        
        $ext = [
                0 => 'xlsx',
                1 => 'xls',
                2 => 'xlsm',
                3 => 'xlsb',
                4 => 'xltm',
                5 => 'xltx',
                6 => 'csv'
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
                $file_upload = $file_upload->move(base_path('storage/upload_tostem/pricemaintenance/tmp'),$filename);
                
                \File::copy(base_path('storage/upload_tostem/pricemaintenance/tmp/'.$filename),base_path('storage/upload_tostem/pricemaintenance/tmp/file_import.'.$ext_name));
                
                $path_filenew =  storage_path().'/upload_tostem/pricemaintenance/tmp/file_import.'.$ext_name;
                
                $excel = new ExcelService($path_filenew,new ProductSellingCodePrice);
                $excel->_gen_file_txt(); 
                $check = $excel->_check_data_import();
               // $check = $this->check_data_file_upload($file_upload, $filename);
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
                        'filename' => $filename, 
                        'user' => $user_id, 
                        'status' => '0'
                    ]
                );
                $data_history =  HisImportProductSellingCodePrice::select('id','created_at')->orderBy('id', 'desc')->limit(1)->get();
                
                $id =  $data_history[0]->id;
                
                $time_conver_tmp = $data_history[0]->created_at->format('Y_m_m_H_i_s');
                
                File::makeDirectory(base_path('storage/upload_tostem/pricemaintenance/'.$id));
                
                \File::copyDirectory(storage_path().'/upload_tostem/pricemaintenance/tmp/',base_path('storage/upload_tostem/pricemaintenance/'.$id.'/'));
                
                //$file_upload = $file_upload->move(base_path('storage/upload_tostem/pricemaintenance/'.$id),$filename);
                
                if(File::exists(base_path('storage/upload_tostem/pricemaintenance/tmp')) == true ) 
                {
                    File::deleteDirectory(base_path('storage/upload_tostem/pricemaintenance/tmp'));
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

           
           
           $path_filenew =  storage_path().'/upload_tostem/pricemaintenance/'.$id.'/file_import.'.$ext_name;
           
           $file_txt = $excel->_update_path($id);
           
           if(file_exists($file_txt) == true){
               $excel->setNametabletmp($time_conver_tmp);
               $excel->_insert_data_tmp();
               $excel->setNamefile($baseName);
               $excel->gen_file_log_excel();
               $excel->_insert_data();
              
               
               HisImportProductSellingCodePrice::UpdateStatus($id,9);
               $return['status'] = 'OK';
               $_all_historys = HisImportProductSellingCodePrice::Getalldata();
               $html = view('tostem.admin.pmaintenance.module-content.module-listhistory', compact('_all_historys'))->render();
               $return['html'] = $html;
               $return['msg'] = 'Import Success ! ';
               File::delete($path_lock);
               return $return;
                
           }else{
                    HisImportProductSellingCodePrice::UpdateStatus($id,6);
                    $return['status'] = 'NG';
                    $_all_historys = HisImportProductSellingCodePrice::Getalldata();
                    $html = view('tostem.admin.pmaintenance.module-content.module-listhistory', compact('_all_historys'))->render();
                    $return['html'] = $html;
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
    public function check_data_file_upload($file_upload, $filename){
        $file_upload = $file_upload->move(base_path('storage/upload_tostem/pricemaintenance/tmp'),$filename);
        $path_filenew =  storage_path().'/upload_tostem/pricemaintenance/tmp/'.$filename;
        $import = new ImportDataDb;
        $file_txt = $import->export_txt($path_filenew);
        $datas = $import->extract_data_from_txt($file_txt, 0, 1);
        $return = [];
        $column = [ 0 => 'design',
                    1 => 'width',
                    2 => 'height',
                    3 => 'special',
                    4 => 'amount'
                ];
        $colum_ex = array_map('strtolower', $datas['columns']);  
        foreach ($colum_ex as $key => $value)
        {
            if (!isset($column[$key]) || $value != $column[$key])
                {
                    $return['status'] = 'err_column';
                    return $return;
                }
        }
        $pos_null = [];
        foreach ($datas['datas'] as $key => $value) {
            $pos = $key+2;
            if($value[0] == '')
            {  
                $pos_null[] = 'A_'.$pos;
            }
            if($value[4] == '')
            {   
                $pos_null[] = 'E_'.$pos;
            }
        }
        $pos_null = implode(', ',$pos_null);
        if(strlen($pos_null) > 0)
        {
            $return['status'] = 'err_data';
            $return['pos_null'] = $pos_null;
        }
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
    
    public function upload_status(){
         $path_lock = base_path('storage/upload_tostem/pricemaintenance/lock_import');
         File::delete($path_lock);
         HisImportProductSellingCodePrice::UpdateStatuserrorall();
    }
    



}