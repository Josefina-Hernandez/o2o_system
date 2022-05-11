<?php

namespace App\Models\Tostem;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OptionSellingCodePrice extends Model
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
     
     protected $fillable_tmp;
     
     protected $_key_data;
     
     protected $_value_data;
     
     protected $_col_export;
 
     
     public function __construct(array $attributes = [])
    {
          
         $this->primaryKey = config('const_db_tostem.db.option_selling_code_price.column.ID');
          
         $this->table = config('const_db_tostem.db.option_selling_code_price.nametable');
          
         $this->fillable = [
                    config('const_db_tostem.db.option_selling_code_price.column.DESIGN'),
                    config('const_db_tostem.db.option_selling_code_price.column.WIDTH'),
                    config('const_db_tostem.db.option_selling_code_price.column.HEIGHT'),
                    config('const_db_tostem.db.option_selling_code_price.column.SPECIAL'),
                    config('const_db_tostem.db.option_selling_code_price.column.AMOUNT'),
                    config('const_db_tostem.db.option_selling_code_price.column.WIDTHORG'),
                    config('const_db_tostem.db.option_selling_code_price.column.HEIGHTORG'),
                        /* add new 2020/05/20 */
                    config('const_db_tostem.db.product_selling_code_price.column.MATERIAL'),
                    config('const_db_tostem.db.product_selling_code_price.column.GLASS_TYPE'),
                    config('const_db_tostem.db.product_selling_code_price.column.GLASS_THICKNESS'),  
                     /* end add new 2020/05/20 */
             ];
         
          $this->fillable_tmp = [
                    config('const_db_tostem.db.option_selling_code_price.column.DESIGN'),
                    config('const_db_tostem.db.option_selling_code_price.column.WIDTH'),
                    config('const_db_tostem.db.option_selling_code_price.column.HEIGHT'),
                    config('const_db_tostem.db.option_selling_code_price.column.SPECIAL'),
                    config('const_db_tostem.db.option_selling_code_price.column.AMOUNT'),
                        /* add new 2020/05/20 */
                    config('const_db_tostem.db.product_selling_code_price.column.MATERIAL'),
                    config('const_db_tostem.db.product_selling_code_price.column.GLASS_TYPE'),
                    config('const_db_tostem.db.product_selling_code_price.column.GLASS_THICKNESS'),  
                     /* end add new 2020/05/20 */
             ];
         $this->_key_data = [
                    config('const_db_tostem.db.option_selling_code_price.column.DESIGN'),
                    config('const_db_tostem.db.option_selling_code_price.column.WIDTH'),
                    config('const_db_tostem.db.option_selling_code_price.column.HEIGHT'),
                    config('const_db_tostem.db.option_selling_code_price.column.SPECIAL'),
         ];
         
         $this->_value_data = [
                    config('const_db_tostem.db.option_selling_code_price.column.AMOUNT')
         ];
         
         $this->_col_export = [
                    config('const_db_tostem.db.option_selling_code_price.column.DESIGN'),
                    config('const_db_tostem.db.option_selling_code_price.column.WIDTH'),
                    config('const_db_tostem.db.option_selling_code_price.column.HEIGHT'),
                    config('const_db_tostem.db.option_selling_code_price.column.SPECIAL'),
                    config('const_db_tostem.db.option_selling_code_price.column.AMOUNT'),
                        /* add new 2020/05/20 */
                    config('const_db_tostem.db.product_selling_code_price.column.MATERIAL'),
                    config('const_db_tostem.db.product_selling_code_price.column.GLASS_TYPE'),
                    config('const_db_tostem.db.product_selling_code_price.column.GLASS_THICKNESS'),  
                     /* end add new 2020/05/20 */
                    NULL
                    ,'Result'
         ];
         $this->_col_log_error = [
                    config('const_db_tostem.db.option_selling_code_price.column.DESIGN'),
                    config('const_db_tostem.db.option_selling_code_price.column.WIDTH'),
                    config('const_db_tostem.db.option_selling_code_price.column.HEIGHT'),
                    config('const_db_tostem.db.option_selling_code_price.column.SPECIAL'),
                    config('const_db_tostem.db.option_selling_code_price.column.AMOUNT'),
                        /* add new 2020/05/20 */
                    config('const_db_tostem.db.product_selling_code_price.column.MATERIAL'),
                    config('const_db_tostem.db.product_selling_code_price.column.GLASS_TYPE'),
                    config('const_db_tostem.db.product_selling_code_price.column.GLASS_THICKNESS'),  
                     /* end add new 2020/05/20 */
                    NULL
                    ,'error'
         ];
         

        parent::__construct($attributes);
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
    

}
