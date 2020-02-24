<?php

namespace App\Services;

use App\Models\Shop;
use Illuminate\Support\Facades\Session;

/**
 * 画面に表示したいメッセージを登録するクラス
 *
 */
class NoticeMessageService
{
    /**
     * @var string
     */
    private $bagName = 'notice_message_bag';

    public function __construct()
    {
        //
    }

    /**
     * セッションからメッセージを取得する
     *
     * @return array
     */
    public function get()
    {
        return Session::pull($this->bagName) ?: [];
    }

    /**
     * セッションにメッセージを登録する。
     * メッセージと併せてステータスを登録する。
     *
     * @param string $message メッセージ
     * @param string $status メッセージのステータス
     */
    public function set(string $message, string $status = 'status')
    {
        $new = [
            config('const.common.notice_message.MESSAGE') => $message,
            config('const.common.notice_message.STATUS') => $status,
        ];
        Session::push($this->bagName, $new);
    }

    /**
     * メッセージをgrayステータスで登録する
     * set()のラップ関数
     *
     * @param string メッセージ
     */
    public function gray(string $message)
    {
        $this->set($message, config('const.common.notice_message.status.GRAY'));
    }

    /**
     * メッセージをorangeステータスで登録する
     * set()のラップ関数
     *
     * @param string メッセージ
     */
    public function orange(string $message)
    {
        $this->set($message, config('const.common.notice_message.status.ORANGE'));
    }

    /**
     * 公開状態に応じてメッセージを表示する
     * 会員管理画面: マイページTOP
     *
     * gray()のラップ関数
     *
     * @param $shopId ショップID
     */
    public function adminShop($shopId)
    {
        $shop = Shop::find($shopId);
        if ($shop === null) return;

        $message = '';
        if ($shop->isStandardPrivate() || $shop->isStandardPreview()) {
            $message .= '<p class="title">このサイトは未公開状態です。公開するには LIXIL簡易見積りシステム事務局までご連絡ください。</p>';

            if ($shop->isStandardPreview()) {
                $message .= '<table>';
                $message .= '<tr><td>プレビューURL</td><td><a href="' . $shop->siteUrl() . '" target="_blank">' . $shop->siteUrl() . '</a></td></tr>';
                $message .= '<tr><td>Basic認証 ID</td><td>' . config('app.basic_authentication_id') . '</td></tr>';
                $message .= '<tr><td>パスワード</td><td>' . config('app.basic_authentication_password') . '</td></tr>';
                $message .= '</table>';
            }
        } else if ($shop->isPremiumPrivate()) {
            $message .= '<p class="title">このサイトは未公開状態です。公開するには LIXIL簡易見積りシステム事務局までご連絡ください。</p>';
        }

        if (! empty($message)) {
            // grayで登録する
            $this->gray($message);
        }
    }

    /**
     * お知らせ登録完了メッセージを表示する
     * 会員管理画面: お知らせ管理
     *
     * orange()のラップ関数
     */
    public function adminShopNews()
    {
        $message = '<p class="title">お知らせの登録を完了しました</p>';

        $this->orange($message);
    }

    /**
     * スタッフ登録完了メッセージを表示する
     * 会員管理画面: スタッフ管理
     *
     * orange()のラップ関数
     */
    public function adminShopStaff()
    {
        $message = '<p class="title">スタッフの登録を完了しました</p>';

        $this->orange($message);
    }

    /**
     * 緊急メッセージ登録完了メッセージを表示する
     * 会員管理画面: 緊急メッセージ管理
     *
     * orange()のラップ関数
     */
    public function adminShopEmergencyMessage()
    {
        $message = '<p class="title">緊急メッセージを変更しました</p>';

        $this->orange($message);
    }


    /**
     * 施工事例登録確認メッセージを表示する
     * 会員管理画面: 事例編集確認
     *
     * orange()のラップ関数
     */
    public function adminShopPhotoConfirm()
    {
        $message = '<p class="title">以下の内容で施工事例を投稿します</p>';

        $this->orange($message);
    }

    /**
     * バナー登録完了メッセージを表示する
     * 加盟店管理画面: バナー管理
     *
     * orange()のラップ関数
     */
    public function adminShopBanner()
    {
        $message = '<p class="title">バナーの登録を完了しました</p>';

        $this->orange($message);
    }
}