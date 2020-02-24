<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminUserAccessPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * 認証されたユーザーが担当しているショップにアクセスしているかを判定する
     */
    public function suitableShop(User $user, $shopId)
    {
        $shop = $user->shop()->first();
        if ($shop === null) {
            // ソフトデリート等で現在存在しないショップの担当者である時
            return false;
        };

        return ((int)$shopId === $shop->{config('const.db.shops.ID')});
    }

    /**
     * 認証されたユーザーがスタンダード店舗管理画面を閲覧可能かを決定する
     */
    public function standard(User $user)
    {
        return $user->isStandard();
    }

    /**
     * 認証されたユーザーがプレミアム店舗管理画面を閲覧可能かを決定する
     */
    public function premium(User $user)
    {
        return $user->isPremium();
    }

    /**
     * 認証されたユーザーがプレミアム店舗管理画面を閲覧可能かを決定する
     */
    public function employee(User $user)
    {
        return $user->isEmployee();
    }


    /**
     * 認証されたユーザーがショップ担当者であるかどうかを判定する
     */
    public function standardOrPremium(User $user)
    {
        return $this->standard($user) || $this->premium($user) || $this->employee($user);
    }

    /**
     * 認証されたユーザーがLIXIL管理者であるかどうかを判定する
     */
    public function lixil(User $user)
    {
        //return $user->isLixil();
        return $user->isAdmin();
    }
}
