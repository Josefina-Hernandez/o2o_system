<?php

namespace App\Models\Tostem;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TDataConvertUpdateDataGiesta extends Model
{

    protected $table;

    protected $primaryKey;
    
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
     protected $fillable_tmp;
    
    
    
     public $_table_alias  = "t_q";
     public $timestamps = false;


     public function __construct(array $attributes = [])
    {
          
         $this->primaryKey = 'id';
          
         $this->table = 't_data_convert_update_data_giesta';
          
         $this->fillable = [
                    'spec51'
                   ,'spec51_name'
                   ,'spec53'
                   ,'spec53_name'
                   ,'spec56'
                   ,'spec56_name'
                   ,'d_except'
                   ,'d_size'
                   ,'d_before'
                   ,'d_after'
                   ,'flg_action'
             ];
         
         $this->fillable_tmp = [
                   'spec51'
                   ,'spec51_name'
                   ,'spec53'
                   ,'spec53_name'
                   ,'spec56'
                   ,'spec56_name'
                   ,'d_except'
                   ,'d_size'
                   ,'d_before'
                   ,'d_after'
                   ,'flg_action'
             ];
         
         

        parent::__construct($attributes);
    }
    
    public function getColumnTmp(){
         return $this->fillable_tmp;
    }
   

}
