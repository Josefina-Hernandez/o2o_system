<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StandardArticle extends Model
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
            config('const.db.standard_articles.SHOP_ID') => 1,
            config('const.db.standard_articles.CATEGORY') => '',
            config('const.db.standard_articles.PUBLISHED_AT') => now(),
            config('const.db.standard_articles.TITLE') => '',
            config('const.db.standard_articles.SUMMARY') => '',
            config('const.db.standard_articles.TEXT') => '',
        ];

        $this->fillable = [
            config('const.db.standard_articles.SHOP_ID'),
            config('const.db.standard_articles.CATEGORY'),
            config('const.db.standard_articles.PUBLISHED_AT'),
            config('const.db.standard_articles.TITLE'),
            config('const.db.standard_articles.SUMMARY'),
            config('const.db.standard_articles.TEXT'),
        ];

        $this->dates = [
            config('const.db.standard_articles.PUBLISHED_AT'),
            config('const.db.standard_articles.CREATED_AT'),
            config('const.db.standard_articles.DELETED_AT'),
        ];

        $this->casts = [
            config('const.db.standard_articles.CATEGORY') => 'string',
        ];

        parent::__construct($attributes);
    }

    /**
     * このスタンダード記事に紐付くショップを取得
     */
    public function shop()
    {
        return $this->belongsTo('App\Models\Shop');
    }

    /**
     * 公開日を 2019年4月1日 の形式で取得する。
     * 月日の0パディングはしない。
     * 
     * @return string
     */
    public function getPublishedDate()
    {
        return $this->{config('const.db.standard_articles.PUBLISHED_AT')}->format('Y年n月j日');
    }

    /**
     * カテゴリ名を取得する
     * 
     * @return string
     */
    public function getCategoryName()
    {
        return config('const.form.admin.shop.standard_article.CATEGORY')[$this->{config('const.db.standard_articles.CATEGORY')}];
    }

    /** 
     * 記事のメイン画像URLを取得する。
     * 
     * @param string $sizeName 画像のサイズを指定する。サイズはconst.common.image.MAX_LENGTHS参照
     * @return string
     */
    public function articleMainImageUrl($sizeName = 's')
    {
        return app()->make('image_get')->standardArticleMainUrl($this->{config('const.db.standard_articles.ID')}, $sizeName);
    }

    /**
     * カテゴリが現場ブログかどうかを判定する
     * 
     * @return bool
     */
    public function isBlog()
    {
        return $this->{config('const.db.standard_articles.CATEGORY')} == $this::CATEGORY_BLOG;
    }

    /**
     * カテゴリがイベント・キャンペーンかどうかを判定する
     * 
     * @return bool
     */
    public function isEvent()
    {
        return $this->{config('const.db.standard_articles.CATEGORY')} == $this::CATEGORY_EVENT;
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
        return $query->where(config('const.db.standard_articles.SHOP_ID'), $shopId);
    }

    /**
     * カテゴリが現場ブログであることを指定するクエリスコープ
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBlog($query)
    {
        return $query->where(config('const.db.standard_articles.CATEGORY'), StandardArticle::CATEGORY_BLOG);
    }

    /**
     * カテゴリがイベント・キャンペーンであることを指定するクエリスコープ
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEvent($query)
    {
        return $query->where(config('const.db.standard_articles.CATEGORY'), StandardArticle::CATEGORY_EVENT);
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
        return $query->latest(config('const.db.standard_articles.CREATED_AT'));
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
     * 現在日時までの記事を絞り込むクエリスコープ
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeToDate($query)
    {
        return $query->where(config('const.db.standard_articles.PUBLISHED_AT'), '<=', now());
    }
}
