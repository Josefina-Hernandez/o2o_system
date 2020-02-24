<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShopClass extends Model
{
    use SoftDeletes;

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
    protected $dates;

    public function __construct(array $attributes = [])
    {
        $this->attributes = [];

        $this->fillable = [];

        $this->dates = [
            config('const.db.shop_classes.DELETED_AT'),
        ];

        parent::__construct($attributes);
    }

    /**
     * LIXIL管理者かどうかを判定する
     *
     * @return bool
     */
    public function isLixil()
    {
        return $this->{config('const.db.shop_classes.ID')} === config('const.common.shops.classes.LIXIL');
    }
    
    /**
     * スタンダードショップ管理者かどうかを判定する
     *
     * @return bool
     */
    public function isStandard()
    {
        return $this->{config('const.db.shop_classes.ID')} === config('const.common.shops.classes.STANDARD');
    }
    
    /**
     * プレミアムショップ管理者かどうかを判定する
     *
     * @return bool
     */
    public function isPremium()
    {
        return $this->{config('const.db.shop_classes.ID')} === config('const.common.shops.classes.PREMIUM');
    }
    
    /**
     * Check Employee 
     *
     * @return bool
     */
    public function isEmployee()
    {
        return $this->{config('const.db.shop_classes.ID')} === config('const.common.shops.classes.EMPLOYEE');
    }
    
}
