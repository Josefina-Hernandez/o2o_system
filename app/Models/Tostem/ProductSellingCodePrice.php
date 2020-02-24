<?php

namespace App\Models\Tostem;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductSellingCodePrice extends Model
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
     
     protected $fillable_tmp;
     
     protected $_key_data;
     
     protected $_value_data;
     
     protected $_col_export;
 
     
     public function __construct(array $attributes = [])
    {
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
         

        parent::__construct($attributes);
    }
    
    public function getColumnExport(){
         return $this->_col_export;
    }
    public function getColumnTmp(){
         return $this->fillable_tmp;
    }
    

}
