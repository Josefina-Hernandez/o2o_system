<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StandardPhoto extends Model
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

    public function __construct(array $attributes = [])
    {
        $this->attributes = [
            config('const.db.standard_photos.SHOP_ID') => 1,
            config('const.db.standard_photos.TITLE') => '',
            config('const.db.standard_photos.SUMMARY') => '',
            config('const.db.standard_photos.MAIN_TEXT') => '',
            config('const.db.standard_photos.BEFORE_TEXT') => '',
            config('const.db.standard_photos.AFTER_TEXT') => '',
            config('const.db.standard_photos.IS_CUSTOMER_PUBLISH') => false,
            config('const.db.standard_photos.CATEGORY') => '0',
            config('const.db.standard_photos.PARTS') => '{}',
            config('const.db.standard_photos.REASON') => '{}',
            config('const.db.standard_photos.LOCALE') => '',
            config('const.db.standard_photos.PERIOD') => '',
            config('const.db.standard_photos.PRODUCT') => '',
            config('const.db.standard_photos.CATEGORY_FOR_SEARCH') => '{}',
            config('const.db.standard_photos.PET') => null,
        ];

        $this->fillable = [
            config('const.db.standard_photos.SHOP_ID'),
            config('const.db.standard_photos.TITLE'),
            config('const.db.standard_photos.SUMMARY'),
            config('const.db.standard_photos.MAIN_TEXT'),
            config('const.db.standard_photos.BEFORE_TEXT'),
            config('const.db.standard_photos.AFTER_TEXT'),
            config('const.db.standard_photos.IS_CUSTOMER_PUBLISH'),
            config('const.db.standard_photos.CUSTOMER_TEXT'),
            config('const.db.standard_photos.CUSTOMER_TEXT_2'),
            config('const.db.standard_photos.CATEGORY'),
            config('const.db.standard_photos.BUILT_YEAR'),
            config('const.db.standard_photos.PARTS'),
            config('const.db.standard_photos.REASON'),
            config('const.db.standard_photos.LOCALE'),
            config('const.db.standard_photos.BUDGET'),
            config('const.db.standard_photos.PERIOD'),
            config('const.db.standard_photos.PRODUCT'),
            config('const.db.standard_photos.CATEGORY_FOR_SEARCH'),
            config('const.db.standard_photos.CLIENT_AGE'),
            config('const.db.standard_photos.HOUSEHOLD'),
            config('const.db.standard_photos.CHILD'),
            config('const.db.standard_photos.PET'),
        ];

        $this->dates = [
            config('const.db.standard_photos.CREATED_AT'),
            config('const.db.standard_photos.DELETED_AT'),
        ];

        $this->casts = [
            config('const.db.standard_photos.IS_CUSTOMER_PUBLISH') => 'boolean',
            config('const.db.standard_photos.CATEGORY') => 'string',
            config('const.db.standard_photos.BUILT_YEAR') => 'string',
            config('const.db.standard_photos.CLIENT_AGE') => 'string',
            config('const.db.standard_photos.HOUSEHOLD') => 'string',
            config('const.db.standard_photos.CHILD') => 'string',
            config('const.db.standard_photos.PARTS') => 'json',
            config('const.db.standard_photos.REASON') => 'json',
            config('const.db.standard_photos.CATEGORY_FOR_SEARCH') => 'json',
            config('const.db.standard_photos.PET') => 'json',
        ];

        parent::__construct($attributes);
    }

    /**
     * このスタンダード事例に紐付くショップを取得
     */
    public function shop()
    {
        return $this->belongsTo('App\Models\Shop');
    }

    /**
     * 作成日を 2019年4月1日 の形式で取得する。
     * 月日の0パディングはしない。
     * 
     * @return string
     */
    public function getCreatedDate()
    {
        return $this->{config('const.db.standard_photos.CREATED_AT')}->format('Y年n月j日');
    }

    /** 
     * 事例詳細URLを取得する。
     * 
     * @return string
     */
    public function photoUrl()
    {
        return route('front.shop.standard.photo.detail', [
            'pref_code' => $this->shop->pref->{config('const.db.prefs.CODE')},
            'shop_code' => $this->shop->{config('const.db.shops.SHOP_CODE')},
            'photo_id' => $this->{config('const.db.standard_photos.ID')}
            ]);
    }

    /** 
     * 事例のメイン画像URLを取得する。
     * 
     * @param string $sizeName 画像のサイズを指定する。サイズはconst.common.image.MAX_LENGTHS参照
     * @return string
     */
    public function photoMainImageUrl($sizeName = 's')
    {
        return app()->make('image_get')->standardPhotoMainUrl($this->{config('const.db.standard_photos.ID')}, $sizeName);
    }

    /** 
     * 事例の施工前写真1～3のURLを取得する。
     * 
     * @return array
     */
    public function photoBeforeImageUrls()
    {
        $beforePicture = app()->make('image_get')->standardPhotoBeforeUrl($this->{config('const.db.standard_photos.ID')});
        $beforePicture2 = app()->make('image_get')->standardPhotoBefore2Url($this->{config('const.db.standard_photos.ID')});
        $beforePicture3 = app()->make('image_get')->standardPhotoBefore3Url($this->{config('const.db.standard_photos.ID')});

        return array_where([$beforePicture, $beforePicture2, $beforePicture3], function ($value, $key) {
            return $value !== null;
        });
    }

    /** 
     * 事例の施工後写真1～3URLを取得する。
     * 
     * @return array
     */
    public function photoAfterImageUrls()
    {
        $afterPicture = app()->make('image_get')->standardPhotoAfterUrl($this->{config('const.db.standard_photos.ID')});
        $afterPicture2 = app()->make('image_get')->standardPhotoAfter2Url($this->{config('const.db.standard_photos.ID')});
        $afterPicture3 = app()->make('image_get')->standardPhotoAfter3Url($this->{config('const.db.standard_photos.ID')});

        return array_where([$afterPicture, $afterPicture2, $afterPicture3], function ($value, $key) {
            return $value !== null;
        });
    }

    /** 
     * 事例のお客様の声写真（写真1）URLを取得する。
     * 
     * @return string
     */
    public function photoCustomerImageUrl()
    {
        return app()->make('image_get')->standardPhotoCustomerUrl($this->{config('const.db.standard_photos.ID')});
    }

    /** 
     * 事例のお客様の声写真（写真2）URLを取得する。
     * 
     * @return string
     */
    public function photoCustomer2ImageUrl()
    {
        return app()->make('image_get')->standardPhotoCustomer2Url($this->{config('const.db.standard_photos.ID')});
    }

    /** 
     * 施工箇所を連結して取得する。
     * 
     * @return string
     */
    public function concatParts()
    {
        $result = '';

        foreach ($this->{config('const.db.standard_photos.PARTS')} as $index => $part) {
            if (! $index == 0) {
                $result .= '、';
            }

            $result .= config('const.form.admin.shop.standard_photo.PARTS')[$part];
        }

        return $result;
    }

    /** 
     * ご家族構成に関係する3項目を連結して取得する。
     * 
     * 表示法則:
     * { お施主のご年齢の選択項目名, client_age }、{ 世帯の選択項目名, household }、お子さま{ お子さま の選択項目名, child }
     * 
     * 項目間の文字列リテラルは、文字列リテラルを挟むように複数項目存在する場合にのみ付与する。
     * 
     * 例:
     * 30歳代、ご夫婦、お子さま1名
     * 二世帯、お子さま1名
     * 20歳代、お子さま1名
     * 20歳代、ご夫婦
     * お子さま2名
     * 
     * 3項目がいずれも入力されていない場合、空文字を返却する。
     * 
     * @return string
     */
    public function concatFamily()
    {
        // 入力値の取得
        $clientAge = $this->{config('const.db.standard_photos.CLIENT_AGE')};
        $household = $this->{config('const.db.standard_photos.HOUSEHOLD')};
        $child = $this->{config('const.db.standard_photos.CHILD')};

        // 入力値からconfig/const.phpで定義した値に変換し、結果に格納する
        $result = [];
        $result[] = $clientAge === null || $clientAge == 99
            ? null
            : config('const.form.admin.shop.standard_photo.CLIENT_AGE')[$clientAge];
        $result[] = $household === null || $household == 99
            ? null
            : config('const.form.admin.shop.standard_photo.HOUSEHOLD')[$household];
        $result[] = $child === null || $child == 99
            ? null
            : 'お子さま' . config('const.form.admin.shop.standard_photo.CHILD')[$child];

        // nullを結果から排除する
        $result = array_filter($result, function ($value) {
            return $value !== null;
        });

        return implode('、', $result);
    }

    /** 
     * ペットを連結して取得する。
     * 
     * @return string
     */
    public function concatPet()
    {
        $result = '';

        // ペットが未選択だった場合、モデルをnullで更新するようにしている
        if ($this->{config('const.db.standard_photos.PET')} === null) {
            return '';

        } else {
            foreach ($this->{config('const.db.standard_photos.PET')} as $index => $part) {
                if (! $index == 0) {
                    $result .= '、';
                }
    
                $result .= config('const.form.admin.shop.standard_photo.PET')[$part];
            }

            return $result;
        }
    }

    /**
     * 1つ古い事例を取得する。
     * 
     * @return App\Models\StandardPhoto 1つ古い事例
     */
    public function previous()
    {
        $currentId = $this->{config('const.db.standard_photos.ID')};

        return StandardPhoto::shopId($this->{config('const.db.standard_photos.SHOP_ID')})
            ->where(config('const.db.standard_photos.CREATED_AT'), '<', $this->{config('const.db.standard_photos.CREATED_AT')})
            ->newly()
            ->first();
    }

    /**
     * 1つ新しい事例を取得する。
     * 
     * @return App\Models\StandardPhoto 1つ新しい事例
     */
    public function next()
    {
        $currentId = $this->{config('const.db.standard_photos.ID')};

        return StandardPhoto::shopId($this->{config('const.db.standard_photos.SHOP_ID')})
            ->where(config('const.db.standard_photos.CREATED_AT'), '>', $this->{config('const.db.standard_photos.CREATED_AT')})
            ->old()
            ->first();
    }

    /**
     * 店舗IDを指定するクエリスコープ
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int|string $shopId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeShopId($query, $shopId)
    {
        return $query->where('shop_id', $shopId);
    }

    /**
    * お客様の声掲載フラグが有効であることを示すクエリスコープ
    *
    * @param \Illuminate\Database\Eloquent\Builder $query
    * @return \Illuminate\Database\Eloquent\Builder
    */
    public function scopeHasVoice($query)
    {
        return $query->where(config('const.db.standard_photos.IS_CUSTOMER_PUBLISH'), config('const.common.ENABLE'));
    }

    /**
    * お客様の声掲載フラグが無効であることを示すクエリスコープ
    *
    * @param \Illuminate\Database\Eloquent\Builder $query
    * @return \Illuminate\Database\Eloquent\Builder
    */
    public function scopeNotHaveVoice($query)
    {
        return $query->where(config('const.db.standard_photos.IS_CUSTOMER_PUBLISH'), config('const.common.DISABLE'));
    }

    /**
     * 公開可能であるかどうかを示すクエリスコープ
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsPublic($query)
    {
        return $query->whereHas('shop', function ($query) {
            $query->isPublic();
        });
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
        return $query->latest(config('const.db.standard_photos.CREATED_AT'));
    }

    /**
    * 古い順に並び替えるクエリスコープ
    *
    * @param \Illuminate\Database\Eloquent\Builder $query
    * @return \Illuminate\Database\Eloquent\Builder
    */
    public function scopeOld($query)
    {
        // 作成日の降順を指定する
        return $query->oldest(config('const.db.standard_photos.CREATED_AT'));
    }

    /**
     * フロントの全店舗事例検索に用いる。
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array リクエストから取得したクエリパラメータの配列
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchFront($query, $params)
    {
        return app()->make('search_keywords')->standardPhotosFront($query, $params);
    }

    /**
     * フロントのスタンダード加盟店事例一覧画面の事例検索に用いる。
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array リクエストから取得したクエリパラメータの配列
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchFrontShopStandard($query, $params)
    {
        return app()->make('search_keywords')->standardPhotosFrontShopStandard($query, $params);
    }
}
