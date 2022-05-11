<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CheckDataTmp extends Model
{
     public $_query;
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
     
     
     protected $fillable_tmp;
     
     protected $_key_data;
     
     protected $_value_data;
     
     protected $_col_export;
 
     
     public function __construct(array $attributes = [])
    {
          
         $this->primaryKey = config('const_db_tostem.db.product_selling_code_price.column.ID');
          
         $this->table = config('const_db_tostem.db.product_selling_code_price.nametable');
          
         $this->fillable = [
                    config('const_db_tostem.db.product_selling_code_price.column.DESIGN'),
                    config('const_db_tostem.db.product_selling_code_price.column.WIDTH'),
                    config('const_db_tostem.db.product_selling_code_price.column.HEIGHT'),
                    config('const_db_tostem.db.product_selling_code_price.column.SPECIAL'),
                    config('const_db_tostem.db.product_selling_code_price.column.AMOUNT'),
                    config('const_db_tostem.db.product_selling_code_price.column.WIDTHORG'),
                    config('const_db_tostem.db.product_selling_code_price.column.HEIGHTORG'),  
             ];
         
          $this->fillable_tmp = [
                    config('const_db_tostem.db.product_selling_code_price.column.DESIGN'),
                    config('const_db_tostem.db.product_selling_code_price.column.WIDTH'),
                    config('const_db_tostem.db.product_selling_code_price.column.HEIGHT'),
                    config('const_db_tostem.db.product_selling_code_price.column.SPECIAL'),
                    config('const_db_tostem.db.product_selling_code_price.column.AMOUNT'),
             ];
         $this->_key_data = [
                    config('const_db_tostem.db.product_selling_code_price.column.DESIGN'),
                    config('const_db_tostem.db.product_selling_code_price.column.WIDTH'),
                    config('const_db_tostem.db.product_selling_code_price.column.HEIGHT'),
                    config('const_db_tostem.db.product_selling_code_price.column.SPECIAL'),
         ];
         
         $this->_value_data = [
                    config('const_db_tostem.db.product_selling_code_price.column.AMOUNT')
         ];
         
         $this->_col_export = [
                    config('const_db_tostem.db.product_selling_code_price.column.DESIGN'),
                    config('const_db_tostem.db.product_selling_code_price.column.WIDTH'),
                    config('const_db_tostem.db.product_selling_code_price.column.HEIGHT'),
                    config('const_db_tostem.db.product_selling_code_price.column.SPECIAL'),
                    config('const_db_tostem.db.product_selling_code_price.column.AMOUNT'),
                    NULL
                    ,'Result'
         ];
         $this->_col_log_error = [
                    config('const_db_tostem.db.product_selling_code_price.column.DESIGN'),
                    config('const_db_tostem.db.product_selling_code_price.column.WIDTH'),
                    config('const_db_tostem.db.product_selling_code_price.column.HEIGHT'),
                    config('const_db_tostem.db.product_selling_code_price.column.SPECIAL'),
                    config('const_db_tostem.db.product_selling_code_price.column.AMOUNT'),
                    NULL
                    ,'error'
         ];
         

        parent::__construct($attributes);
        
        //$this->_exportDataAdmin();
        
        
    }
    public function getColumnLog(){
         return $this->_col_log_error;
    }
    public function getColumnExport(){
         return $this->_col_export;
    }
    public function getColumnTmp(){
         return $this->fillable_tmp;
    }
    
    public function _exportDataAdmin($time_conver_tmp){
                
         $quey = " select design,width ,height ,special ,amount  from $time_conver_tmp  order by id ASC
                   ";

         
         $this->_query = DB::select(
               DB::raw($quey)
          );
         return $this->_query;
    }
    
    
    
    

}
