<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

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
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden;

    public function __construct(array $attributes = [])
    {
        $this->attributes = [];

        $this->fillable = [
            config('const.db.users.LOGIN_ID'),
            config('const.db.users.PASSWORD'),
            config('const.db.users.SHOP_ID'),
            config('const.db.users.SHOP_CLASS_ID'),
            config('const.db.users.NAME'),
            config('const.db.users.EMAIL'),
            config('const.db.users.PHONENUMBER'),
            config('const.db.users.COMPANY'),
            config('const.db.users.STATUS'),
            config('const.db.users.ADMIN'),
            config('const.db.users.DEPARTMENT_CODE'),
            config('const.db.users.CREATE_USER'),
            config('const.db.users.M_MAILADDRESS_ID'),
        ];

        $this->hidden = [
            config('const.db.users.PASSWORD'),
        ];

        parent::__construct($attributes);
    }
    
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(config('const.db.users.DEL_FLG'), function (Builder $builder) {
            $builder->where(config('const.db.users.DEL_FLG'), '!=', 1);
        });
      
    }
    
    /**
     * remember meの使用不使用に関わらず、
     * ログアウト時にremember_tokenがupdateされてしまうのを抑制する
     */
    public function setAttribute($key, $value)
    {
        $isRememberTokenAttribute = $key == $this->getRememberTokenName();
        if (! $isRememberTokenAttribute) {
            parent::setAttribute($key, $value);
        }
    }

    /**
     * このユーザーに紐付くショップを取得
     */
    public function shop()
    {
        return $this->belongsTo('App\Models\Shop');
    }

    /**
     * このユーザーに紐付くショップ区分（プラン）を取得
     */
    public function shopClass()
    {
        return $this->belongsTo('App\Models\ShopClass');
    }

    /**
     * LIXIL管理者かどうかを判定する
     *
     * @return bool
     */
    public function isLixil()
    {
        return $this->shopClass()->first()->isLixil();
    }
    
    /**
     * スタンダードショップ管理者かどうかを判定する
     *
     * @return bool
     */
    public function isStandard()
    {
        return $this->shopClass()->first()->isStandard();
    }
    
    /**
     * プレミアムショップ管理者かどうかを判定する
     *
     * @return bool
     */
    public function isPremium()
    {
        return $this->shopClass()->first()->isPremium();
    }

    
     /**
     * is Employee
     *
     * @return bool
     */
    public function isEmployee()
    {
        return $this->shopClass()->first()->isEmployee();
    }
    
    /**
     * SuperAdmin
     *
     * @return bool
    */
    public function isSuperAdmin()
    {
        
        if($this->{config('const.db.users.ADMIN')} == 1 && $this->isLixil()){
            return TRUE;
        }
        if($this->{config('const.db.users.ADMIN')} == 0){
            return FALSE;
        }
       
    }
    public function isAdmin()
    {
        if($this->{config('const.db.users.ADMIN')} == 1 && $this->{config('const.db.users.STATUS')} == 1)
        {
            return true;
        }
        return false;
    }
    /**
     * 復号化されたパスワードを返却する
     * 
     * @return string 復号化されたパスワード
     */
    public function getDecryptedPassword()
    {
        return app()->make('cipher')->decrypt($this->{config('const.db.users.PASSWORD')});
    }
    
    
    public static function beginTransaction()
    {
        DB::beginTransaction();
    }
    public static function rollBack()
    {
        DB::rollBack();
    }
     public static function commit()
    {
        DB::commit();
    }
    
    
}
