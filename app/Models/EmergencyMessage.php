<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmergencyMessage extends Model
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

    /**
     * ネイティブなタイプへキャストする属性
     *
     * @var array
     */
    protected $casts;

    public function __construct(array $attributes = [])
    {
        $this->attributes = [
            config('const.db.emergency_messages.SHOP_ID') => 1,
            config('const.db.emergency_messages.IS_PUBLISH') => '0',
            config('const.db.emergency_messages.TEXT') => '',
        ];

        $this->fillable = [
            config('const.db.emergency_messages.SHOP_ID'),
            config('const.db.emergency_messages.IS_PUBLISH'),
            config('const.db.emergency_messages.TEXT'),
        ];

        $this->dates = [
            config('const.db.emergency_messages.DELETED_AT'),
        ];

        $this->casts = [];

        parent::__construct($attributes);
    }

    /**
     * 店舗IDを指定するクエリスコープ
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int|string $shopId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeShopId($query, $shopId)
    {
        return $query->where('shop_id', $shopId);
    }

    /**
     * 店舗詳細等に掲載することを指定するクエリスコープ
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublish($query)
    {
        return $query->where(config('const.db.emergency_messages.IS_PUBLISH'), config('const.common.ENABLE'));
    }
}
