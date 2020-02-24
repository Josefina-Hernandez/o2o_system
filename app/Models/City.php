<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
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

        $this->fillable = [
            config('const.db.cities.PREF_ID'),
            config('const.db.cities.CODE'),
            config('const.db.cities.NAME'),
        ];

        $this->dates = [
            config('const.db.cities.DELETED_AT'),
        ];

        parent::__construct($attributes);
    }

    /**
     * この市区町村に紐付く都道府県を取得
     */
    public function pref()
    {
        return $this->belongsTo('App\Models\Pref');
    }

    /**
    * 都道府県IDを指定するクエリスコープ
    *
    * @param \Illuminate\Database\Eloquent\Builder $query
    * @param $prefId 都道府県ID
    * @return \Illuminate\Database\Eloquent\Builder
    */
    public function scopePrefId($query, $prefId)
    {
        return $query->where('pref_id', $prefId);
    }

    /**
    * 市区町村コードを指定するクエリスコープ
    *
    * @param \Illuminate\Database\Eloquent\Builder $query
    * @param $cityCode 市区町村コード
    * @return \Illuminate\Database\Eloquent\Builder
    */
    public function scopeCode($query, $cityCode)
    {
        return $query->where('code', $cityCode);
    }
}
