<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GenerateShopHistory extends Model
{
    // Table Name
    protected $table = 't_generate_shop_history';
    // Primary Key
    public $primaryKey = 't_generate_shop_history_id';
    // Timestamps
    public $timestamps = true;


    public function __construct(array $attributes = [])
    {
        $this->attributes = [];

        $this->fillable = [
            config('const.db.t_generate_shop_history.CUSTOMER_NAME'),
            config('const.db.t_generate_shop_history.CUSTOMER_EMAIL'),
            config('const.db.t_generate_shop_history.REPRESENT'),
            config('const.db.t_generate_shop_history.EMAIL_SALES'),
            config('const.db.t_generate_shop_history.LOGIN_INFO_MAIL_CONTENT'),
            config('const.db.t_generate_shop_history.FRONTEND_URL_PUBLISH'),
            config('const.db.t_generate_shop_history.FRONTEND_URL_MAIL_CONTENT'),
            config('const.db.t_generate_shop_history.SHOP_ID')
        ];

        $this->dates = [
            config('const.db.prefs.DELETED_AT'),
        ];

        parent::__construct($attributes);
    }
}
