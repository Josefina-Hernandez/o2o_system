<?php

namespace App\Models\Tostem;

use Illuminate\Database\Eloquent\Model;

class Mquotation extends Model
{
    // Table Name
    protected $table = 'm_quotation';
    // Primary Key
    public $primaryKey = 'm_quotation_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable;
    
    const CREATED_AT = 'add_datetime';
    
    const UPDATED_AT = 'upd_datetime';
    
    public $timestamps = true;

	public $_table_alias  = "m_q";
    public function __construct(array $attributes = [])
    {
        $this->fillable = [
            config('const_db_tostem.db.m_quotation.column.QUOTATION_SESSION'),
            config('const_db_tostem.db.m_quotation.column.QUOTATION_DATE'),
            config('const_db_tostem.db.m_quotation.column.QUOTATION_NO'),
            config('const_db_tostem.db.common_columns.column.DEL_FLG'),
            config('const_db_tostem.db.common_columns.column.ADD_USER_ID'),
            config('const_db_tostem.db.common_columns.column.ADD_DATETIME'),
            config('const_db_tostem.db.common_columns.column.UPD_USER_ID'),
            config('const_db_tostem.db.common_columns.column.UPD_DATETIME'),
            config('const_db_tostem.db.m_quotation.column.QUOTATION_DEPARMENT'),
            config('const_db_tostem.db.m_quotation.column.DATA_CART'),
            config('const_db_tostem.db.m_quotation.column.HTML_CART'),
            config('const_db_tostem.db.m_quotation.column.BUTTON_PDF'),
            config('const_db_tostem.db.m_quotation.column.BUTTON_MAIL'),
            config('const_db_tostem.db.m_quotation.column.NEW_OR_REFORM'), //Add add popup status New/Reform hainp 20200924
        ];
        parent::__construct($attributes);
    }




}
