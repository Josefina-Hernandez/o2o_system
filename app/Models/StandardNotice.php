<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StandardNotice extends Model
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
            config('const.db.standard_notices.PUBLISHED_AT') => now(),
        ];

        $this->fillable = [
            config('const.db.standard_notices.ID'),
            config('const.db.standard_notices.SHOP_ID'),
            config('const.db.standard_notices.PUBLISHED_AT'),
            config('const.db.standard_notices.TEXT'),
            config('const.db.standard_notices.CREATED_AT'),
            config('const.db.standard_notices.UPDATED_AT'),
            config('const.db.standard_notices.DELETED_AT'),
        ];

        $this->dates = [
            config('const.db.standard_notices.PUBLISHED_AT'),
            config('const.db.shops.DELETED_AT'),
        ];

        $this->casts = [];

        parent::__construct($attributes);
    }

    /**
     * 公開日を 2019年4月1日 の形式で取得する。
     * 月日の0パディングはしない。
     * 
     * @return string
     */
    public function getPublishedDate()
    {
        return $this->{config('const.db.standard_notices.PUBLISHED_AT')}->format('Y年n月j日');
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
        return $query->where(config('const.db.standard_notices.SHOP_ID'), $shopId);
    }
    
    /**
     * 新しい順に並び替えるクエリスコープ
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNewly($query)
    {
        // 公開日の降順を指定する
        return $query->latest(config('const.db.standard_notices.PUBLISHED_AT'));
    }

    /**
     * 現在日時までのお知らせを絞り込むクエリスコープ
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeToDate($query)
    {
        return $query->where(config('const.db.standard_notices.PUBLISHED_AT'), '<=', now());
    }
}
