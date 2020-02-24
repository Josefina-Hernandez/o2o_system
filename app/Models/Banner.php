<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
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
            config('const.db.banners.SHOP_ID') => 1,
            config('const.db.banners.RANK') => 0,
            config('const.db.banners.URL') => '',
        ];

        $this->fillable = [
            config('const.db.banners.ID'),
            config('const.db.banners.SHOP_ID'),
            config('const.db.banners.RANK'),
            config('const.db.banners.URL'),
        ];

        $this->dates = [
            config('const.db.banners.DELETED_AT'),
        ];

        $this->casts = [];

        parent::__construct($attributes);
    }

    /**
     * このバナーが有効であるかどうかを判定する。
     * urlに空文字以外が入っていれば有効なバナーとする。
     * urlはDBスキーマでnot nullに指定しているため、nullであるかどうかはここでは考慮しない。
     * 
     * @return boolean
     */
    public function isEnabled()
    {
        $name = $this->{config('const.db.banners.URL')};
        return $name !== '';
    }

    /** 
     * バナー画像URLを取得する。
     * 
     * @return string
     */
    public function imageUrl()
    {
        return app()->make('image_get')->bannerUrl($this->{config('const.db.banners.SHOP_ID')}, $this->{config('const.db.banners.RANK')});
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
     * 並び順を指定するクエリスコープ
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int|string $rank
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRank($query, $rank)
    {
        return $query->where('rank', $rank);
    }

    /**
     * 有効なスタッフを指定するクエリスコープ
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEnable($query)
    {
        return $query->whereNotIn(config('const.db.banners.URL'), ['']);
    }
}
