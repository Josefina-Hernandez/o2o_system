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
     
     
     protected $primaryKey = 'id';
     
     public $timestamps = true;
     
     
    public function __construct(array $attributes = [])
    {
          
         $this->table = config('const_db_tostem.db.history_import_product_selling_code_price.nametable');
          
         $this->attributes = [
                       
               ];
         
         
         $this->fillable = [
                    config('const_db_tostem.db.history_import_product_selling_code_price.column.FILENAME'),
                    config('const_db_tostem.db.history_import_product_selling_code_price.column.USER'),
                    config('const_db_tostem.db.history_import_product_selling_code_price.column.STATUS')
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
                )->join('users', 'users.id', '=', 'history_import_product_selling_code_price.user')->orderBy('history_import_product_selling_code_price.id','DESC')->get();;
    }
    
    static function Searchdata($time_start, $time_end)
    {
         $select =   [
                              'history_import_product_selling_code_price.*'
                              ,'users.'.config('const.db.users.LOGIN_ID')
                  ];
        return self::select(
                $select
                )->join('users', 'users.id', '=', 'history_import_product_selling_code_price.user')->whereRaw('CONVERT(history_import_product_selling_code_price.created_at,DATE) >= ?' ,$time_start)->whereRaw('CONVERT(history_import_product_selling_code_price.created_at,DATE) <= ?' ,$time_end)->orderBy('history_import_product_selling_code_price.id','DESC')->get();;
    }
    
    static function UpdateStatus($id,$status){
         return self::where('id',$id)->update(
                 ['status' => $status]
                 );
    }
    
    static function CheckSatus(){
         
          $count = self::where('status','=',0)->get()->count();
          if($count > 0){
               return FALSE;
          }
          return TRUE;
    }
     static function UpdateStatuserrorall(){
         
          $data_history =  HisImportProductSellingCodePrice::select('id','created_at')->where('status','=',0)->orderBy('id', 'desc')->get();
          
          foreach ($data_history as $his){
               self::UpdateStatus($his->id,6);
               $_time_now = $his->created_at->format('Y_m_m_H_i_s');
               $name_table_tmp =   'tbtmp_'.$_time_now;
               if(\Schema::hasTable($name_table_tmp)){
                    \Schema::dropIfExists($name_table_tmp);
               }
          }
          
        
    }
    
    

    
    
     
}
