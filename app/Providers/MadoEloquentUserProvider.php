<?php

namespace App\Providers;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Support\Facades\Route;

class MadoEloquentUserProvider extends EloquentUserProvider
{
    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  array  $credentials
     * @return bool
     */
    public function validateCredentials(UserContract $user, array $credentials)
    {
        $plain = $credentials['password'];

        $hashCheck = $this->hasher->check($plain, $user->getAuthPassword());
        if ($hashCheck) {
            // LIXILログイン画面であればLIXIL管理者のlogin_idとpasswordを、
            // ショップログイン画面であればショップ担当者のlogin_idとpasswordを入力しているかを検証する
            $currentRoute = Route::getCurrentRoute()->getName();

            if (starts_with($currentRoute, 'admin.shop')) {
                // ユーザーがショップ担当者かどうか検証する
                if ($user->can('standardOrPremium')) {
                    return true;
                }

            } elseif (starts_with($currentRoute, 'admin.lixil')) {
                // ユーザーがLIXIL管理者かどうか検証する
                if ($user->can('lixil')) {
                    return true;
                }

            } elseif (starts_with($currentRoute, 'admin')) {
                return true;

            } elseif (starts_with($currentRoute, 'tostem.front.auth')) {
            	return true;

            } else {
                // admin.shopかadmin.lixilへのログインでなければ拒否する
            }
        }

        return false;
    }
}
