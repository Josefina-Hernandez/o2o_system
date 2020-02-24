<?php

namespace App\Services;

use App\Models\User;

/**
 * ログインユーザーのIDとPWを生成するためのクラス
 */
class UserIdAndPasswordService
{
    /**
     * 新規IDを取得する。
     * IDの形式は mado-**** で、後ろ4文字には半角数字で1から始まる数値が入る。
     * 数値が4桁に満たない場合は0パディングする。
     * 
     * @return string 新規ID
     */
    public function createId()
    {
        // mado- から始まるログインIDをフィルタリングし、その中で最大のID番号を抽出する。
        // 例: $maxId = '0012';
        $maxId = User::all()->filter(function ($user) {
            return starts_with($user->{config('const.db.users.LOGIN_ID')}, 'mado-');
        })->max(function ($user) {
            return str_after($user->{config('const.db.users.LOGIN_ID')}, 'mado-');
        });

        if ($maxId === null) {
            // 登録されているユーザーがいない場合、mado-0001とする。
            return 'mado-0001';

        } else {
            // ID番号を一旦数値に変換し、インクリメントする
            $maxId = intval(ltrim($maxId, '0'));
            $maxId++;
    
            // mado- を付与し、再度0パディングして返却する
            return 'mado-' . str_pad($maxId, 4, '0', STR_PAD_LEFT);
        }
    }

    /**
     * 新規パスワードを取得する。
     * 
     * パスワードは半角大文字, 半角小文字, 半角数字のみで構成され、
     * 紛らわしい文字を含まない。
     * 
     * パスワードの長さは config/const.php の PASSWORD_LENGTH、
     * パスワードに用いる文字は config/const.php の PASSWORD_CHARACTERS にそれぞれ従う。
     * 
     * @return string パスワード
     */
    public function createPassword()
    {
        $result = '';
        $length = config('const.common.users.PASSWORD_LENGTH');

        // パスワードを生成する
        while (strlen($result) < $length) {
            $index = random_int(0, mb_strlen(config('const.common.users.PASSWORD_CHARACTERS')));
            $result .= substr(config('const.common.users.PASSWORD_CHARACTERS'), $index, 1);
        }

        return $result;
    }
}
