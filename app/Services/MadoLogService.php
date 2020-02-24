<?php

namespace App\Services;

use Log;

/**
 * ログを出力するクラス
 * 
 */
class MadoLogService
{
    public function __construct()
    {
        //
    }

    /**
     * ログ出力を行う
     * 
     * @param string $message 出力したいメッセージ。messageの項に表示される
     * @param array $extra 追加出力項目
     * @param string $level ログレベル
     */
    public function log(string $message, array $extra = [], string $level = 'info')
    {
        // 出力項目をリクエストから取得する
        $request = request();
        $outputData = [
            'message' => $message,
            'fullUrl' => $request->fullUrl(),
            'ip' => $request->ip(),
            'userAgent' => $request->userAgent(),
            'user' => $request->user() ? $request->user()->{config('const.db.users.ID')} : 'no auth',
        ];

        if ($request->hasSession()) {
            $outputData['csrf_token'] = $request->session()->get('_token');
        }

        // 出力項目に追加出力項目をマージする
        $outputData = array_merge($outputData, $extra);

        // 出力文字列を生成する
        $output = '';
        $delimiter = ', ';
        foreach ($outputData as $key => $value) {
            $output .= "{$key}: {$value}" . $delimiter;
        }
        $output = str_replace_last($delimiter, '', $output);

        switch ($level) {
            case 'error':
                Log::error($output);
                break;

            case 'info':
                Log::info($output);
                break;

            case 'notice':
                Log::notice($output);
                break;

            case 'warning':
                Log::warning($output);
                break;

            case 'alert':
                Log::alert($output);
                break;

            case 'critical':
                Log::critical($output);
                break;

            case 'emergency':
                Log::emergency($output);
                break;

            case 'debug':
                Log::debug($output);
                break;
        }
    }

    /**
     * ログレベルをemergencyでログ出力を行う
     * 
     * @param $message エラーメッセージ
     * @param array $extra 追加出力項目
     */
    public function emergency($message, array $extra = [])
    {
        $this->log($message, $extra, 'emergency');
    }

    /**
     * ログレベルをalertでログ出力を行う
     * 
     * @param $message エラーメッセージ
     * @param array $extra 追加出力項目
     */
    public function alert($message, array $extra = [])
    {
        $this->log($message, $extra, 'alert');
    }

    /**
     * ログレベルをcriticalでログ出力を行う
     * 
     * @param $message エラーメッセージ
     * @param array $extra 追加出力項目
     */
    public function critical($message, array $extra = [])
    {
        $this->log($message, $extra, 'critical');
    }

    /**
     * ログレベルをerrorでログ出力を行う
     * 
     * @param $message エラーメッセージ
     * @param array $extra 追加出力項目
     */
    public function error($message, array $extra = [])
    {
        $this->log($message, $extra, 'error');
    }

    /**
     * ログレベルをwarningでログ出力を行う
     * 
     * @param $message エラーメッセージ
     * @param array $extra 追加出力項目
     */
    public function warning($message, array $extra = [])
    {
        $this->log($message, $extra, 'warning');
    }

    /**
     * ログレベルをnoticeでログ出力を行う
     * 
     * @param $message エラーメッセージ
     * @param array $extra 追加出力項目
     */
    public function notice($message, array $extra = [])
    {
        $this->log($message, $extra, 'notice');
    }

    /**
     * ログレベルをinfoでログ出力を行う
     * 
     * @param $message エラーメッセージ
     * @param array $extra 追加出力項目
     */
    public function info($message, array $extra = [])
    {
        $this->log($message, $extra, 'info');
    }

    /**
     * ログレベルをdebugでログ出力を行う
     * 
     * @param $message エラーメッセージ
     * @param array $extra 追加出力項目
     */
    public function debug($message, array $extra = [])
    {
        $this->log($message, $extra, 'debug');
    }
}
