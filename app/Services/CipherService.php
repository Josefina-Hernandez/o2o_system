<?php

namespace App\Services;

use Illuminate\Contracts\Hashing\Hasher;

/**
 * 可逆的な暗号化処理および復号化処理を提供するクラス
 * 
 * 使用するアルゴリズムは config/app.php の cipher に準拠する。
 * ユーザー情報のハッシュ化の代替として使うため、Hasherインターフェースを実装し、
 * hash としてサービスコンテナに登録する。
 */
class CipherService implements Hasher
{
    // 生成するランダムバイトの長さ
    const NUMBER_DIGITS = 16;

    public function make($value, array $options = [])
    {
        return $this->encrypt($value);
    }

    public function check($value, $hashedValue, array $options = [])
    {
        return ($value == $this->decrypt($hashedValue));
    }

    public function needsRehash($hashedValue, array $options = [])
    {
        return false;
    }

    /**
     * config/app.phpから、cipherとkeyとivをそれぞれアルゴリズムとキーとして用い、暗号化する。
     * 
     * @param $value
     * @param array $options
     * @return string|bool
     */
    public function encrypt($value, $info = '')
    {
        // salt値をランダムバイトから生成する
        $salt = openssl_random_pseudo_bytes($this::NUMBER_DIGITS);

        // keyをsaltとapp.keyから生成する
        $key = hash_hkdf('sha256', config('app.key'), 0, $info, $salt);

        // 暗号文をkeyとapp.ivから生成する
        $encrypted = openssl_encrypt($value, config('app.cipher'), $key, 0, base64_decode(config('app.iv')));

        // (salt値 + 暗号文)をbase64エンコードして返す
        return base64_encode($salt . $encrypted);
    }

    /**
     * config/app.phpから、cipherとkeyとivをそれぞれアルゴリズムとキーとして用い、復号化する。
     * 
     * @param $value
     * @param array $options
     * @return string|bool
     */
    public function decrypt($value, $info = '')
    {
        // base64デコードして(salt値 + 暗号文)を取り出す
        $body = base64_decode($value);
        $salt = substr($body, 0, $this::NUMBER_DIGITS);
        $encrypted = substr($body, $this::NUMBER_DIGITS);

        // keyをsaltとapp.keyから生成する
        $key = hash_hkdf('sha256', config('app.key'), 0, $info, $salt);

        // 暗号文をkeyとapp.ivから復号する
        return openssl_decrypt($encrypted, config('app.cipher'), $key, 0, base64_decode(config('app.iv')));
    }
}
