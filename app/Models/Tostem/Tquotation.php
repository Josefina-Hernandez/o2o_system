<?php

namespace App\Models\Tostem;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tquotation extends Model
{

    protected $table = 't_quotation';

    protected $primaryKey  = 't_quotation_id';
    
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
     
     public $_table_alias  = "t_q";
     public $timestamps = false;


     public function __construct(array $attributes = [])
    {
          
        /* $this->primaryKey = config('const_db_tostem.db.t_quotation.column.NO');
          
         $this->table = config('const_db_tostem.db.t_quotation.nametable');*/
          
         $this->fillable = [
                    config('const_db_tostem.db.t_quotation.column.T_QUOTATION_ID'),
                    config('const_db_tostem.db.t_quotation.column.M_QUOTATION_ID'),
                    config('const_db_tostem.db.t_quotation.column.QUOTATION_USER'),
                    config('const_db_tostem.db.t_quotation.column.ITEM'),
                    config('const_db_tostem.db.t_quotation.column.HL'),
                    config('const_db_tostem.db.t_quotation.column.MATERIAL'),
                    config('const_db_tostem.db.t_quotation.column.DESIGN'),
                    config('const_db_tostem.db.t_quotation.column.REF'),
                    config('const_db_tostem.db.t_quotation.column.QTY'),
                    config('const_db_tostem.db.t_quotation.column.ONE_WINDOW'),
                    config('const_db_tostem.db.t_quotation.column.JOINT'),
                    config('const_db_tostem.db.t_quotation.column.SCREEN'),
                    config('const_db_tostem.db.t_quotation.column.OFF_SPEC'),
                    config('const_db_tostem.db.t_quotation.column.MAIN_GLASS'),
                    config('const_db_tostem.db.t_quotation.column.COLOR'),
                    config('const_db_tostem.db.t_quotation.column.W'),
                    config('const_db_tostem.db.t_quotation.column.H'),
                    config('const_db_tostem.db.t_quotation.column.W_OPENING'),
                    config('const_db_tostem.db.t_quotation.column.H_OPENING'),
                    config('const_db_tostem.db.t_quotation.column.SPECIAL_CODE'),
                    config('const_db_tostem.db.t_quotation.column.GLASS_TYPE'),
                    config('const_db_tostem.db.t_quotation.column.GLASS_HIC_ENESS'),
                    config('const_db_tostem.db.t_quotation.column.MATERIAL_REFERENCE'),
                    config('const_db_tostem.db.t_quotation.column.MATERIAL_DESCRIPTION'),
             'del_flg'
             
             ];

        parent::__construct($attributes);
    }
   

}
