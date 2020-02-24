<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PremiumArticle extends Model
{
    use SoftDeletes;
    
    /**
     * カテゴリが現場ブログである
     * 
     * @var int
     */
    const CATEGORY_BLOG = 1;

    /**
     * カテゴリがイベントキャンペーンである
     * 
     * @var int
     */
    const CATEGORY_EVENT = 2;

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
            config('const.db.premium_articles.SHOP_ID') => 1,
            config('const.db.premium_articles.WP_ARTICLE_ID') => 0,
            config('const.db.premium_articles.WP_ARTICLE_URL') => '',
            config('const.db.premium_articles.POSTED_AT') => Carbon::create(2018, 0, 0, 0, 0, 0),
            config('const.db.premium_articles.CATEGORY') => 0,
            config('const.db.premium_articles.TITLE') => '',
            config('const.db.premium_articles.SUMMARY') => '',
            config('const.db.premium_articles.FEATURED_IMAGE_URL') => '',
        ];

        $this->fillable = [
            config('const.db.premium_articles.SHOP_ID'),
            config('const.db.premium_articles.WP_ARTICLE_ID'),
            config('const.db.premium_articles.WP_ARTICLE_URL'),
            config('const.db.premium_articles.POSTED_AT'),
            config('const.db.premium_articles.CATEGORY'),
            config('const.db.premium_articles.TITLE'),
            config('const.db.premium_articles.SUMMARY'),
            config('const.db.premium_articles.FEATURED_IMAGE_URL'),
        ];

        $this->dates = [
            config('const.db.premium_photos.POSTED_AT'),
            config('const.db.premium_articles.DELETED_AT'),
        ];

        $this->casts = [];

        parent::__construct($attributes);
    }

    /**
     * このプレミアム記事に紐付くショップを取得
     */
    public function shop()
    {
        return $this->belongsTo('App\Models\Shop');
    }

    /** 
     * 記事のアイキャッチ画像URLを取得する。
     * featured_image_urlカラムがnullだった場合、ダミー画像のURLを返却する。
     * 
     * @return string
     */
    public function featuredImageUrl()
    {
        return $this->{config('const.db.premium_articles.FEATURED_IMAGE_URL')}
            ?? app()->make('image_get')->dummyFeaturedImage();
    }

    /**
     * 公開日時を 2019年4月1日 の形式で取得する。
     * 月日の0パディングはしない。
     * 
     * @return string
     */
    public function getPostedDate()
    {
        return $this->{config('const.db.premium_articles.POSTED_AT')}->format('Y年n月j日');
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
     * カテゴリを指定するクエリスコープ
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int|string $category
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCategory($query, $category)
    {
        return $query->where(config('const.db.premium_articles.CATEGORY'), $category);
    }

    /**
     * カテゴリが現場ブログであることを指定するクエリスコープ
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBlog($query)
    {
        return $query->where(config('const.db.premium_articles.CATEGORY'), $this::CATEGORY_BLOG);
    }

    /**
     * カテゴリがイベント・キャンペーンであることを指定するクエリスコープ
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEvent($query)
    {
        return $query->where(config('const.db.premium_articles.CATEGORY'), $this::CATEGORY_EVENT);
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
}