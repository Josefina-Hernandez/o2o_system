<?php

namespace App\Models\Tostem;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class HisImportProductSellingCodePrice extends Model
{
    
     /**
     * 初期値を決定する
     *
     * @var array
     */
    protected $attributes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable;

    /**
     * 日付へキャストする属性
     *
     * @var array
     */
     protected $table;
     
     
     protected $primaryKey ;
     
     public $timestamps = false;
     
     
    public function __construct(array $attributes = [])
    {
         $this->primaryKey = config('const_db_tostem.db.history_import_product_selling_code_price.column.ID');
         
         $this->table = config('const_db_tostem.db.history_import_product_selling_code_price.nametable');
          
         $this->attributes = [
                       
               ];
         
         
         $this->fillable = [
                    config('const_db_tostem.db.history_import_product_selling_code_price.column.FILENAME'),
                    config('const_db_tostem.db.history_import_product_selling_code_price.column.STATUS'),
                    config('const_db_tostem.db.history_import_product_selling_code_price.column.OPTION'),
                    config('const_db_tostem.db.common_columns.column.ADD_USER_ID'),
                    config('const_db_tostem.db.common_columns.column.ADD_DATETIME'),
                    config('const_db_tostem.db.common_columns.column.UPD_USER_ID'), 
                    config('const_db_tostem.db.common_columns.column.UPD_DATETIME'),
             ];
        parent::__construct($attributes);
    }
    
    
    
    public function scopeGetalldata($query)
    {
         $select =   [
                              'history_import_product_selling_code_price.*'
                               ,'users.'.config('const.db.users.LOGIN_ID')
                  ];
                
        return $query->select(
                $select
                )->join('users', 'users.id', '=', 'history_import_product_selling_code_price.'.config('const_db_tostem.db.common_columns.column.ADD_USER_ID').'')->where('history_import_product_selling_code_price.del_flg','=',0)->whereRaw('users.'.config('const.db.users.DEL_FLG'). '  =  0 ')->orderBy('history_import_product_selling_code_price.id','DESC')->get();
    }
    
    static function Searchdata($time_start, $time_end)
    {
         $select =   [
                              'history_import_product_selling_code_price.*'
                              ,'users.'.config('const.db.users.LOGIN_ID')
                  ];
        if($time_start != '' && $time_end != ''){ 
          return self::select(
                  $select
                  )->join('users', 'users.id', '=', 'history_import_product_selling_code_price.'.config('const_db_tostem.db.common_columns.column.ADD_USER_ID').'')->where('history_import_product_selling_code_price.del_flg','=',0)->whereRaw('users.'.config('const.db.users.DEL_FLG'). '  =  0 ')->whereRaw('CONVERT(history_import_product_selling_code_price.'.config('const_db_tostem.db.common_columns.column.ADD_DATETIME').',DATE) >= ?' ,$time_start)->whereRaw('CONVERT(history_import_product_selling_code_price.'.config('const_db_tostem.db.common_columns.column.ADD_DATETIME').',DATE) <= ?' ,$time_end)->orderBy('history_import_product_selling_code_price.id','DESC')->get();
    
        } 
        
        if($time_start == '' && $time_end != ''){ 
          return self::select(
                  $select
                  )->join('users', 'users.id', '=', 'history_import_product_selling_code_price.'.config('const_db_tostem.db.common_columns.column.ADD_USER_ID').'')->where('history_import_product_selling_code_price.del_flg','=',0)->whereRaw('users.'.config('const.db.users.DEL_FLG'). '  =  0 ')->whereRaw('CONVERT(history_import_product_selling_code_price.'.config('const_db_tostem.db.common_columns.column.ADD_DATETIME').',DATE) <= ?' ,$time_end)->orderBy('history_import_product_selling_code_price.id','DESC')->get();
    
        }
        
        if($time_start != '' && $time_end == ''){ 
        
          return self::select(
                  $select
                  )->join('users', 'users.id', '=','history_import_product_selling_code_price.'.config('const_db_tostem.db.common_columns.column.ADD_USER_ID').'')->where('history_import_product_selling_code_price.del_flg','=',0)->whereRaw('users.'.config('const.db.users.DEL_FLG'). '  =  0 ')->whereRaw('CONVERT(history_import_product_selling_code_price.'.config('const_db_tostem.db.common_columns.column.ADD_DATETIME').',DATE) >= ?' ,$time_start)->orderBy('history_import_product_selling_code_price.id','DESC')->get();
    
        }
        
        if($time_start == '' && $time_end == ''){ 
          return self::select(
                  $select
                  )->join('users', 'users.id', '=', 'history_import_product_selling_code_price.'.config('const_db_tostem.db.common_columns.column.ADD_USER_ID').'')->where('history_import_product_selling_code_price.del_flg','=',0)->whereRaw('users.'.config('const.db.users.DEL_FLG'). '  =  0 ')->orderBy('history_import_product_selling_code_price.id','DESC')->get();
    
        } 
        
    }
    
    static function UpdateStatus($id,$status){
         
         $time_conver_tmp = date('Y_m_d_H_i_s');
         
         return self::where(config('const_db_tostem.db.history_import_product_selling_code_price.column.ID'),$id)->update(
                    [
                        config('const_db_tostem.db.history_import_product_selling_code_price.column.STATUS') => $status,
                        config('const_db_tostem.db.common_columns.column.UPD_DATETIME') =>$time_conver_tmp,
                    ]
                 );
    }
    
    static function CheckSatus(){
         
          $count = self::where(config('const_db_tostem.db.history_import_product_selling_code_price.column.STATUS'),'=',0)->get()->count();
          if($count > 0){
               return FALSE;
          }
          return TRUE;
    }
     static function UpdateStatuserrorall(){
          
          $_key_id = config('const_db_tostem.db.history_import_product_selling_code_price.column.ID');
          $colum_time = config('const_db_tostem.db.common_columns.column.ADD_DATETIME');
          
          if(\File::exists(base_path('storage/upload_tostem/pricemaintenance/tmp')) == true ) 
          {
              \File::deleteDirectory(base_path('storage/upload_tostem/pricemaintenance/tmp'));
           }
          $data_history =  HisImportProductSellingCodePrice::select($_key_id,$colum_time)->where(config('const_db_tostem.db.history_import_product_selling_code_price.column.STATUS'),'=',0)->orderBy($_key_id, 'desc')->get();
          
          foreach ($data_history as $his){
            
               self::UpdateStatus($his->$_key_id,6);
               $_time_now = date("Y_m_d_H_i_s", strtotime($his->$colum_time));
               $name_table_tmp =   'tbtmp_'.$_time_now;
               if(\Schema::hasTable($name_table_tmp)){
                    \Schema::dropIfExists($name_table_tmp);
               }
               
          }
          
        
    }
    
    

    
    
     
}
