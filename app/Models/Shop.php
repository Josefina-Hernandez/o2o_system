<?php

namespace App\Models;

use App\Models\{
    City,
    Pref
};
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shop extends Model
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

    /**
     * ネイティブなタイプへキャストする属性
     *
     * @var array
     */
    protected $casts;

    /**
     * prefCode have not generate
     * @var string
     */
    public $prefCode = '{generate_pref}';

    public function __construct(array $attributes = [])
    {
        $this->attributes = [
            config('const.db.shops.SHOP_CLASS_ID') => (string)config('const.common.shops.classes.STANDARD'),
            config('const.db.shops.OPEN_TIME') => Carbon::createFromTime(0, 0)->toTimeString(),
            config('const.db.shops.CLOSE_TIME') => Carbon::createFromTime(0, 0)->toTimeString(),
            config('const.db.shops.HAS_T_POINT') => '0',
            config('const.db.shops.IS_NO_RATE') => '0',
            config('const.db.shops.CAN_PAY_BY_CREDIT_CARD') => '0',
            config('const.db.shops.CAN_SIMULATE') => '0',
            config('const.db.shops.IS_MADO_MEISTER') => '0',
            config('const.db.shops.STANDARD_SHOP_PUBLISH_STATUS') => '1',
            config('const.db.shops.IS_PUBLISHED_PREMIUM') => '1',
            config('const.db.shops.SUPPORT_DETAIL_LIST') => '{}',
        ];

        $this->fillable = [
            config('const.db.shops.SHOP_CLASS_ID'),
            config('const.db.shops.NAME'),
            config('const.db.shops.COMPANY_NAME'),
            config('const.db.shops.COMPANY_NAME_KANA'),
            config('const.db.shops.KANA'),
            config('const.db.shops.PRESIDENT_NAME'),
            config('const.db.shops.PERSONNEL_NAME'),
            config('const.db.shops.ZIP1'),
            config('const.db.shops.ZIP2'),
            config('const.db.shops.PREF_ID'),
            config('const.db.shops.CITY_ID'),
            config('const.db.shops.STREET'),
            config('const.db.shops.BUILDING'),
            config('const.db.shops.LATITUDE'),
            config('const.db.shops.LONGITUDE'),
            config('const.db.shops.SUPPORT_AREA'),
            config('const.db.shops.TEL'),
            config('const.db.shops.FAX'),
            config('const.db.shops.EMAIL'),
            config('const.db.shops.OPEN_TIME'),
            config('const.db.shops.CLOSE_TIME'),
            config('const.db.shops.OTHER_TIME'),
            config('const.db.shops.NORMALLY_CLOSE_DAY'),
            config('const.db.shops.SUPPORT_DETAIL'),
            config('const.db.shops.SUPPORT_DETAIL_LIST'),
            config('const.db.shops.CERTIFICATE'),
            config('const.db.shops.SITE_URL'),
            config('const.db.shops.CAPITAL'),
            config('const.db.shops.COMPANY_START'),
            config('const.db.shops.COMPANY_HISTORY'),
            config('const.db.shops.LICENSE'),
            config('const.db.shops.EMPLOYEE_NUMBER'),
            config('const.db.shops.MESSAGE'),
            config('const.db.shops.PHOTO_SUMMARY'),
            config('const.db.shops.HAS_T_POINT'),
            config('const.db.shops.IS_NO_RATE'),
            config('const.db.shops.CAN_PAY_BY_CREDIT_CARD'),
            config('const.db.shops.IS_MADO_MEISTER'),
            config('const.db.shops.TWITTER'),
            config('const.db.shops.FACEBOOK'),
            config('const.db.shops.SHOP_CODE'),
            config('const.db.shops.PREMIUM_SHOP_DOMAIN'),
            config('const.db.shops.CAN_SIMULATE'),
            config('const.db.shops.STANDARD_SHOP_PUBLISH_STATUS'),
            config('const.db.shops.IS_PUBLISHED_PREMIUM'),
            config('const.db.shops.SHOP_TYPE'),
        ];

        $this->dates = [
            config('const.db.shops.DELETED_AT'),
        ];

        $this->casts = [
            config('const.db.shops.SHOP_CLASS_ID') => 'string',
            config('const.db.shops.STANDARD_SHOP_PUBLISH_STATUS') => 'string',
            config('const.db.shops.IS_PUBLISHED_PREMIUM') => 'string',
            config('const.db.shops.SUPPORT_DETAIL_LIST') => 'json',

        ];

        parent::__construct($attributes);
    }

    /**
     * このショップに紐付くショップ区分（プラン）を取得
     */
    public function shopClass()
    {
        return $this->belongsTo('App\Models\ShopClass');
    }

    /**
     * このショップに紐付く都道府県を取得
     */
    public function pref()
    {
        return $this->belongsTo('App\Models\Pref');
    }

    /**
     * このショップに紐付く市区町村を取得
     */
    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }

    /**
     * このショップの担当者を取得
     */
    public function user()
    {
        return $this->hasOne('App\Models\User');
    }

    /**
     * このショップのプレミアム事例を取得
     */
    public function premiumPhotos()
    {
        return $this->hasMany('App\Models\PremiumPhoto');
    }

    /**
     * このショップのスタンダード事例を取得
     */
    public function standardPhotos()
    {
        return $this->hasMany('App\Models\StandardPhoto');
    }

    /**
     * このショップのスタンダードお知らせを取得
     */
    public function standardNotices()
    {
        return $this->hasMany('App\Models\StandardNotice');
    }

    /**
     * このショップのスタッフを取得
     */
    public function staffs()
    {
        return $this->hasMany('App\Models\Staff');
    }

    /**
     * このショップの緊急メッセージを取得
     */
    public function emergencyMessage()
    {
        return $this->hasMany('App\Models\EmergencyMessage');
    }

    public function generate_shop_history () {
        return $this->hasOne('App\Models\GenerateShopHistory');
    }

    /**
     * ショップの住所を取得する。
     * pref_idとcity_idとstreetとbuildingを連結する。
     *
     * @return string
     */
    public function address()
    {
        $prefName = '';
        $cityName = '';
        $pref = Pref::find($this->{config('const.db.shops.PREF_ID')});
        if ($pref !== null) {
            $prefName = $pref->{config('const.db.prefs.NAME')};
        }
        $city = City::find($this->{config('const.db.shops.CITY_ID')});
        if ($city !== null) {
            $cityName = $city->{config('const.db.cities.NAME')};
        }
        $street = $this->{config('const.db.shops.STREET')};
        $building = $this->{config('const.db.shops.BUILDING')};

        return $prefName . $cityName . $street . $building;
    }

    /**
     * ショップの営業時間を取得する。
     *
     * @return string
     */
    public function openingTime()
    {
        return Carbon::createFromTimeString($this->{config('const.db.shops.OPEN_TIME')})->format('G:i')
            . '～'
            . Carbon::createFromTimeString($this->{config('const.db.shops.CLOSE_TIME')})->format('G:i');
    }

    public function telWithoutHyphen()
    {
        return preg_replace('/-/', '', $this->{config('const.db.shops.TEL')});
    }

    /**
     * ショップのサイトパスを取得する。
     *
     * プレミアム: プレミアムショップドメインを返却する
     * スタンダード: ポータルサイトのドメイン以下の相対パスを返却する
     *
     * @return string サイトパス
     */
    public function sitePath()
    {
        $shopClass = $this->shopClass;
        if ($shopClass->isPremium()) {
            return $this->{config('const.db.shops.PREMIUM_SHOP_DOMAIN')};

        } else if ($shopClass->isStandard()) {
            $prefCode = $this->pref->{config('const.db.prefs.CODE')};
            return '/shop/' . $prefCode . '/' . $this->{config('const.db.shops.SHOP_CODE')};
        }
    }

    /**
     * ショップのサイトURLを返却する。
     *
     * スタンダードショップの場合、会員詳細ページへのURLを返却する。
     * プレミアムショップの場合、プロトコルは https:// とし、
     * 外部のWordPressページへのURLを返却する。
     *
     * @return string サイトURL
     */
    public function siteUrl()
    {
        $path = $this->sitePath();

        if ($this->shopClass->isStandard()) {
            return url($path);

        } else if ($this->shopClass->isPremium()) {
            $protocol = 'https://';
            return $protocol . $path;

        } else {
            return $path;
        }
    }

    /**
     * Estimate: custom function siteUrl use for shop/search
     * @return string Url site portal
     */
    public function siteUrlPortal()
    {
        $prefCode_model = $this->pref;
        if($prefCode_model){
            $this->prefCode = $this->pref->{config('const.db.prefs.CODE')};
        };
    	$path = '/shop/' . $this->prefCode . '/' . $this->{config('const.db.shops.SHOP_CODE')};

    	return url($path);
    }

    /**
     * ショップのお問い合わせURLを返却する。
     *
     * スタンダードショップの場合、会員お問い合わせページへのURLを返却する。
     * プレミアムショップの場合、プロトコルは https:// とし、
     * 外部のWordPressページへのURLを返却する。
     *
     * @return string お問い合わせURL
     */
    public function contactUrl()
    {
        if ($this->shopClass->isStandard()) {
            return route('front.shop.standard.contact', [
                'pref_code' => $this->pref->{config('const.db.prefs.CODE')},
                'shop_code' => $this->{config('const.db.shops.SHOP_CODE')}
            ]);

        } else if ($this->shopClass->isPremium()) {
            $protocol = 'https://';
            return $protocol . $this->{config('const.db.shops.PREMIUM_SHOP_DOMAIN')} . '/contact';

        } else {
            return '';
        }
    }

    /**
     * スタンダード公開ステータスを取得する。
     * ショップ区分（プラン）に応じて参照するカラムを変更する。
     *
     * @return string
     */
    public function publishStatus()
    {
        if ($this->isPremium()) {
            return config('const.form.admin.lixil.shop.PREMIUM_PUBLISH_FLG')[$this->{config('const.db.shops.IS_PUBLISHED_PREMIUM')}];

        } else if ($this->isStandard()) {
            return config('const.form.admin.lixil.shop.STANDARD_PUBLISH_STATUS')[$this->{config('const.db.shops.STANDARD_SHOP_PUBLISH_STATUS')}];
        }
    }

    /**
     * 対応サービスに含まれるTポイント連携フラグ, 無金利フラグ, クレジットカード決済フラグに対し、
     * 選択されているものだけを、区切り文字で出力する。
     * 例: Tポイント連携フラグ, 無金利フラグが選択されている場合、'Tポイント連携／無金利'が出力される
     *
     * @param string $separate 区切り文字
     * @return string
     */
    public function serviceFlags($separate = '／')
    {
        $result = [];

        // Tポイント連携フラグ
        if ($this->{config('const.db.shops.HAS_T_POINT')} == (string)config('const.common.ENABLE')) {
            $result[] = 'Tポイント連携';
        }

        // 無金利フラグ
        if ($this->{config('const.db.shops.IS_NO_RATE')} == (string)config('const.common.ENABLE')) {
            $result[] = '無金利';
        }

        // クレジットカード決済フラグ
        if ($this->{config('const.db.shops.CAN_PAY_BY_CREDIT_CARD')} == (string)config('const.common.ENABLE')) {
            $result[] = 'クレジットカード決済';
        }

        // フラグが一切立っていない場合、'対応サービス無し'を格納する
        if (empty($result)) {
            $result[] = '対応サービス無し';
        }

        return implode($separate, $result);
    }

    /**
     * 取扱施工内容を連結して取得する。
     * 
     * @return string
     */
    public function concatSupportDetails()
    {
        $result = '';

        foreach ($this->{config('const.db.shops.SUPPORT_DETAIL_LIST')} as $index => $supportDetail) {
            if (! $index == 0) {
                $result .= '、';
            }

            $result .= config('const.form.admin.shop.SUPPORT_DETAIL_LIST')[$supportDetail];
        }

        return $result;
    }

    /**
    * スタンダードショップかどうかを判定する
    *
    * @return bool
    */
   public function isStandard()
   {
       return $this->shopClass->isStandard();
   }

   /**
    * プレミアムショップかどうかを判定する
    *
    * @return bool
    */
    public function isPremium()
    {
        return $this->shopClass->isPremium();
    }

    /**
     * このショップのスタンダード公開ステータスがプレビューかどうかを返却する
     *
     * @return boolean このショップがプレビューステータスかどうか
     */
    public function isStandardPreview()
    {
        return $this->isStandard()
            && $this->{config('const.db.shops.STANDARD_SHOP_PUBLISH_STATUS')}
            == config('const.common.shops.standard_publish_status.PREVIEW');
    }

    /**
     * このショップのスタンダード公開ステータスが非公開かどうかを返却する
     *
     * @return boolean このショップが非公開ステータスかどうか
     */
    public function isStandardPrivate()
    {
        return $this->isStandard()
            && $this->{config('const.db.shops.STANDARD_SHOP_PUBLISH_STATUS')}
            == config('const.common.shops.standard_publish_status.PRIVATE');
    }

    /**
     * このショップのスタンダード公開ステータスが公開かどうかを返却する
     *
     * @return boolean このショップが公開ステータスかどうか
     */
    public function isStandardPublic()
    {
        return $this->isStandard()
            && $this->{config('const.db.shops.STANDARD_SHOP_PUBLISH_STATUS')}
            == config('const.common.shops.standard_publish_status.PUBLIC');
    }

    /**
     * このショップのプレミアム公開ステータスが非公開かどうかを返却する
     *
     * @return boolean このショップが非公開ステータスかどうか
     */
    public function isPremiumPrivate()
    {
        return $this->isPremium()
            && $this->{config('const.db.shops.STANDARD_SHOP_PUBLISH_STATUS')}
            == config('const.common.shops.premium_publish_status.PRIVATE');
    }

    /**
     * このショップのプレミアム公開ステータスが公開かどうかを返却する
     *
     * @return boolean このショップが公開ステータスかどうか
     */
    public function isPremiumPublic()
    {
        return $this->isPremium()
            && $this->{config('const.db.shops.STANDARD_SHOP_PUBLISH_STATUS')}
            == config('const.common.shops.premium_publish_status.PUBLIC');
    }

    /**
    * 都道府県コードを指定するクエリスコープ
    *
    * @param \Illuminate\Database\Eloquent\Builder $query
    * @param $prefCode 都道府県コード
    * @return \Illuminate\Database\Eloquent\Builder
    */
    public function scopePrefCode($query, $prefCode)
    {
        $pref = Pref::code($prefCode)->first();
        return $query->where(config('const.db.shops.PREF_ID'), $pref->{config('const.db.prefs.ID')});
    }

    /**
    * 市区町村コードを指定するクエリスコープ
    *
    * @param \Illuminate\Database\Eloquent\Builder $query
    * @param $cityCode 市区町村コード
    * @return \Illuminate\Database\Eloquent\Builder
    */
    public function scopeCityCode($query, $cityCode)
    {
        $city = City::code($cityCode)->first();
        return $query->where(config('const.db.shops.CITY_ID'), $city->{config('const.db.cities.ID')});
    }

    /**
    * ショップコードを指定するクエリスコープ
    *
    * @param \Illuminate\Database\Eloquent\Builder $query
    * @param $shopCode ショップコード
    * @return \Illuminate\Database\Eloquent\Builder
    */
    public function scopeCode($query, $shopCode)
    {
        return $query->where(config('const.db.shops.SHOP_CODE'), $shopCode);
    }

    /**
    * ショップ区分にプレミアムを指定するクエリスコープ
    *
    * @param \Illuminate\Database\Eloquent\Builder $query
    * @return \Illuminate\Database\Eloquent\Builder
    */
    public function scopePremium($query)
    {
        return $query->where(config('const.db.shops.SHOP_CLASS_ID'), config('const.common.shops.classes.PREMIUM'));
    }

    /**
    * ショップ区分にスタンダードを指定するクエリスコープ
    *
    * @param \Illuminate\Database\Eloquent\Builder $query
    * @return \Illuminate\Database\Eloquent\Builder
    */
    public function scopeStandard($query)
    {
        return $query->where(config('const.db.shops.SHOP_CLASS_ID'), config('const.common.shops.classes.STANDARD'));
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
        return $query->latest(config('const.db.shops.CREATED_AT'));
    }

    /**
     * LIXIL管理画面の会員検索に用いる。
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array リクエストから取得したクエリパラメータの配列
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchAdminShop($query, $params)
    {
        return app()->make('search_keywords')->shopsAdmin($query, $params);
    }

    /**
     * フロントトップのショップキーワード検索に用いる。
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array リクエストから取得したクエリパラメータの配列
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchFrontKeyword($query, $params)
    {
        return app()->make('search_keywords')->shopsFrontKeyword($query, $params);
    }

    /**
     * 公開ステータスが公開であることを示すクエリスコープ
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsPublic($query)
    {
        return $query->where(function ($query) {
            $query
                ->orWhere(function ($query) {
                    // プレミアムかつプレミアム公開ステータスが公開
                    $query->premium()->where(config('const.db.shops.IS_PUBLISHED_PREMIUM'), config('const.common.shops.premium_publish_status.PUBLIC'));
                })
                ->orWhere(function ($query) {
                    // スタンダードかつスタンダード公開ステータスが公開
                    $query->standard()->where(config('const.db.shops.STANDARD_SHOP_PUBLISH_STATUS'), config('const.common.shops.standard_publish_status.PUBLIC'));
                });
        });
    }

    /**
     * 見積りシミュレーションが可能であることを示すクエリスコープ
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCanSimulate($query)
    {
        return $query->where(config('const.db.shops.CAN_SIMULATE'), config('const.common.ENABLE'));
    }

    /**
     * プレミアムショップドメインを指定するクエリスコープ
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
    * @param $domain プレミアムショップドメイン
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePremiumShopDomain($query, $domain)
    {
        return $query->where(config('const.db.shops.PREMIUM_SHOP_DOMAIN'), $domain);
    }


    public function isFirstTimeEdit () {
        $GenerateShopHistory = GenerateShopHistory::where('shop_id', $this->{config('const.db.shops.ID')})->get()->first();
        if ($GenerateShopHistory !== null && $GenerateShopHistory->frontend_url_publish == 1) {
            return false;
        }
        if ($GenerateShopHistory == null) { // Old shops
            return false;
        }
        return true;
    }

    public function get_url_shop($type) {
        $prefCode = $this->pref->{config('const.db.prefs.CODE')};
        return '/shop/' . $prefCode . '/' . $this->{config('const.db.shops.SHOP_CODE')}."/$type/step1";
    }
}
