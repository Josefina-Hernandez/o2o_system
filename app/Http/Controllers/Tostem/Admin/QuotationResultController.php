<?php
namespace App\Http\Controllers\Tostem\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tostem\{
              Quotation
};
use Illuminate\Http\Request;
use App\Services\ExcelService;


Class QuotationResultController extends Controller
{

    public function __construct()
    {
         $this->middleware('auth');
    }

    public function index (Request $request) {
         
       
       $_all_historys = Quotation::Searchdata([]);
       
       if ($request->ajax()) {
               if($_all_historys->count() > 0){
                         $html = view('tostem.admin.quotationresult.module-content.module-child-data',compact('_all_historys'))->render();
                         $return['html'] = $html;
                         return $return;
               }
               $return['status'] = 'full';
               return $return;
        }
        
       return view('tostem.admin.quotationresult.index',compact('_all_historys'));
       
    }
    
    public function searchdata(Request $request) {
         
          $regEx = '/^\d{4}\/\d{2}\/\d{2}$/';

          $param = $request->all();
          
          
          
          $param_where = [];
          if(!empty($param['quotaition_no'])){
               
               $param_where['quotaition_no'] = $param['quotaition_no'];
               
          }
          if(!empty($param['time_strart'])){
               
               $check_date = preg_match($regEx,$param['time_strart']);
               if(!$check_date){
                    $return['status'] = 'error_time';
                    return $return;
               }
               
               $param_where['time_strart'] = $param['time_strart'];
               
          }
          if(!empty($param['time_end'])){

               $check_date = preg_match($regEx,$param['time_end']);
               if(!$check_date){
                    $return['status'] = 'error_time';
                    return $return;
               }
               
               $param_where['time_end'] = $param['time_end'];
               
          }
           if(!empty($param['page'])){

               $param_where['page'] = $param['page'];
               
          }
          
          
          $_all_historys = Quotation::Searchdata($param_where);
          
            if ($request->ajax()) {
                 
                    if(isset($param['page'])){
                         
                         if($_all_historys->count() > 0){
                                  $html = view('tostem.admin.quotationresult.module-content.module-child-data',compact('_all_historys'))->render();
                                   $return['html'] = $html;
                                   return $return;
                         }
                         
                         $return['status'] = 'full';
                         return $return;
                    }else{
                           $html = view('tostem.admin.quotationresult.module-content.module-child-data',compact('_all_historys'))->render();
                           $return['html'] = $html;
                           return $return;
                    }
            }
    }
    
    
    
     public function downloadfile(Request $request){
          
          $regEx = '/^\d{4}\/\d{2}\/\d{2}$/';
          
          $param = $request->all();
          
          $param_where = [];
          
          if(!empty($param['quotaition_no'])){
               
               $param_where['quotaition_no'] = $param['quotaition_no'];
               
          }
          if(!empty($param['time_strart'])){
               
               $check_date = preg_match($regEx,$param['time_strart']);
               if(!$check_date){
                    $return['status'] = 'error_time';
                    return $return;
               }
               
               $param_where['time_strart'] = $param['time_strart'];
               
          }
          if(!empty($param['time_end'])){
               
               $check_date = preg_match($regEx,$param['time_end']);
               if(!$check_date){
                    $return['status'] = 'error_time';
                    return $return;
               }
               
               $param_where['time_end'] = $param['time_end'];
               
          }
           if(!empty($param['page'])){
               
               $param_where['page'] = $param['page'];
               
          }
          
         
          $name_result = 'quotation_result_'.date('yymdhms').'.csv';
          
          
          $elo = new Quotation();
          
          $elo->setTypeSelect(1);
          
          $elo->_exportDataAdmin($param_where);
          
          
          $csv = new ExcelService('',$elo);
          
          $csv->setNamefile($name_result);

          $column_export = [
            'stt',
            'login_id',
            'quotation_date',
            'quotation_no',
            'new_or_reform',
            'material',
            'design',
            'ref',
            'qty',
            'color_code',
            'w',
            'h',
            'amount'
          ];

          $csv->setColumnDataExport($column_export);
          
          $csv->setHeaderExcel(array_keys($elo->getColumnExport()));
          $csv->setAutoIncrease('stt');
          $csv->_exportCsvToBrowser();
  
    }
    public function checkAuth(){
         
          $return['status'] = 'OK';
          return $return; 
          
    }


}