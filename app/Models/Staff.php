<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    use SoftDeletes;

    /**
     * モデルと関連しているテーブル
     *
     * @var string
     */
    protected $table = 'staffs';

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
            config('const.db.staffs.SHOP_ID') => 1,
            config('const.db.staffs.RANK') => 0,
            config('const.db.staffs.NAME') => '',
            config('const.db.staffs.MESSAGE') => '',
            config('const.db.staffs.CERTIFICATE') => '',
            config('const.db.staffs.HOBBY') => '',
            config('const.db.staffs.CASE') => '',
            config('const.db.staffs.POST') => '',
        ];

        $this->fillable = [
            config('const.db.staffs.ID'),
            config('const.db.staffs.SHOP_ID'),
            config('const.db.staffs.RANK'),
            config('const.db.staffs.POST'),
            config('const.db.staffs.NAME'),
            config('const.db.staffs.MESSAGE'),
            config('const.db.staffs.CERTIFICATE'),
            config('const.db.staffs.HOBBY'),
            config('const.db.staffs.CASE'),
        ];

        $this->dates = [
            config('const.db.staffs.DELETED_AT'),
        ];

        $this->casts = [];

        parent::__construct($attributes);
    }

    /**
     * このスタッフが有効であるかどうかを判定する。
     * nameに空文字以外が入っていれば有効なスタッフとする。
     * nameはDBスキーマでnot nullに指定しているため、nullであるかどうかはここでは考慮しない。
     * 
     * @return boolean
     */
    public function isEnabled()
    {
        $name = $this->{config('const.db.staffs.NAME')};
        return $name !== '';
    }

    /** 
     * スタッフ画像URLを取得する。
     * 
     * @return string
     */
    public function imageUrl()
    {
        return app()->make('image_get')->staffUrl($this->{config('const.db.staffs.SHOP_ID')}, $this->{config('const.db.staffs.RANK')});
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
        return $query->whereNotIn(config('const.db.staffs.NAME'), ['']);
    }
}
