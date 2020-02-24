<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;
     /**
     * このショップの担当者を取得
     */
    public function user()
    {
        return $this->hasOne('App\Models\User');
    }

    /**
    * 新しい順に並び替えるクエリスコープ
    *
    * @param \Illuminate\Database\Eloquent\Builder $query
    * @return \Illuminate\Database\Eloquent\Builder
    */
    public function scopeNewly($query)
    {
        // 作成日の降順を指定する
        return $query->latest(config('const.db.employees.CREATED_AT'));
    }
}