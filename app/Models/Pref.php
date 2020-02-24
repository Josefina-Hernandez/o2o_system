<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pref extends Model
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
            config('const.db.prefs.CODE'),
            config('const.db.prefs.NAME'),
        ];

        $this->dates = [
            config('const.db.prefs.DELETED_AT'),
        ];

        parent::__construct($attributes);
    }

    /**
    * 都道府県名を指定するクエリスコープ
    *
    * @param \Illuminate\Database\Eloquent\Builder $query
    * @param $prefName 都道府県名
    * @return \Illuminate\Database\Eloquent\Builder
    */
    public function scopeName($query, $prefName)
    {
        return $query->where('name', $prefName);
    }

    /**
    * 都道府県コードを指定するクエリスコープ
    *
    * @param \Illuminate\Database\Eloquent\Builder $query
    * @param $prefCode 都道府県コード
    * @return \Illuminate\Database\Eloquent\Builder
    */
    public function scopeCode($query, $prefCode)
    {
        return $query->where(config('const.db.prefs.CODE'), $prefCode);
    }
}
