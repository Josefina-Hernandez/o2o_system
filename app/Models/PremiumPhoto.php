<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PremiumPhoto extends Model
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

    public function __construct(array $attributes = [])
    {
        $this->attributes = [
            config('const.db.premium_photos.SHOP_ID') => 1,
            config('const.db.premium_photos.WP_ARTICLE_ID') => 0,
            config('const.db.premium_photos.WP_ARTICLE_URL') => '',
            config('const.db.premium_photos.POSTED_AT') => Carbon::create(2018, 0, 0, 0, 0, 0),
            config('const.db.premium_photos.TITLE') => '',
            config('const.db.premium_photos.SUMMARY') => '',
            config('const.db.premium_photos.IS_CUSTOMER_PUBLISH') => '0',
            config('const.db.premium_photos.FEATURED_IMAGE_URL') => '',
        ];

        $this->fillable = [
            config('const.db.premium_photos.SHOP_ID'),
            config('const.db.premium_photos.WP_ARTICLE_ID'),
            config('const.db.premium_photos.WP_ARTICLE_URL'),
            config('const.db.premium_photos.POSTED_AT'),
            config('const.db.premium_photos.TITLE'),
            config('const.db.premium_photos.SUMMARY'),
            config('const.db.premium_photos.IS_CUSTOMER_PUBLISH'),
            config('const.db.premium_photos.FEATURED_IMAGE_URL'),
        ];

        $this->dates = [
            config('const.db.premium_photos.POSTED_AT'),
            config('const.db.premium_photos.DELETED_AT'),
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
     * 公開日時を 2019年4月1日 の形式で取得する。
     * 月日の0パディングはしない。
     * 
     * @return string
     */
    public function getPostedDate()
    {
        return $this->{config('const.db.premium_photos.POSTED_AT')}->format('Y年n月j日');
    }

    /** 
     * 事例詳細URLを取得する。
     * 
     * @return string
     */
    public function photoUrl()
    {
        return $this->{config('const.db.premium_photos.WP_ARTICLE_URL')};
    }

    /** 
     * 事例のアイキャッチ画像URLを取得する。
     * featured_image_urlカラムがnullだった場合、ダミー画像のURLを返却する。
     * 
     * @return string
     */
    public function featuredImageUrl()
    {
        return $this->{config('const.db.premium_photos.FEATURED_IMAGE_URL')}
            ?? app()->make('image_get')->dummyFeaturedImage();
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
     * 記事IDを指定するクエリスコープ
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int|string $articleId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWpArticle($query, $articleId)
    {
        return $query->where('wp_article_id', $articleId);
    }

    /**
    * お客様の声掲載フラグが有効であることを示すクエリスコープ
    *
    * @param \Illuminate\Database\Eloquent\Builder $query
    * @return \Illuminate\Database\Eloquent\Builder
    */
    public function scopeHasVoice($query)
    {
        return $query->where(config('const.db.premium_photos.IS_CUSTOMER_PUBLISH'), config('const.common.ENABLE'));
    }

    /**
    * お客様の声掲載フラグが無効であることを示すクエリスコープ
    *
    * @param \Illuminate\Database\Eloquent\Builder $query
    * @return \Illuminate\Database\Eloquent\Builder
    */
    public function scopeNotHaveVoice($query)
    {
        return $query->where(config('const.db.premium_photos.IS_CUSTOMER_PUBLISH'), config('const.common.DISABLE'));
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
     * フロントの全店舗事例検索に用いる。
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array リクエストから取得したクエリパラメータの配列
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchFront($query, $params)
    {
        return app()->make('search_keywords')->premiumPhotosFront($query, $params);
    }
}
