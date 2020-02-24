<?php

namespace App\Services;

use App\Models\{
    PremiumArticle,
    StandardArticle
};

/**
 * スタンダートとプレミアムの記事を取得するサービス
 */
class GetArticlesService
{
    /**
     * カテゴリが現場ブログである記事を取得し、
     * created_atでソートする。
     * 
     * @param $limit 取得件数
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function blog($limit = null, $unique = true)
    {
        $premiumArticles = PremiumArticle::isPublic()->blog()->get();
        $standardArticles = StandardArticle::isPublic()->blog()->toDate()->get();

        $articles = $this->merge($premiumArticles, $standardArticles);
        $articles = $this->newly($articles);
        if ($unique) {
            $articles = $this->uniqueByShop($articles);
        }

        if ($limit === null) {
            return $articles;
            
        } else {
            return $this->limit($articles, $limit);
        }
    }

    /**
     * カテゴリがイベント・キャンペーンである記事を取得し、
     * created_atでソートする。
     * 
     * @param $limit 取得件数
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function event($limit = null, $unique = true)
    {
        $premiumArticles = PremiumArticle::isPublic()->event()->get();
        $standardArticles = StandardArticle::isPublic()->event()->toDate()->get();

        $articles = $this->merge($premiumArticles, $standardArticles);
        $articles = $this->newly($articles);
        if ($unique) {
            $articles = $this->uniqueByShop($articles);
        }

        if ($limit === null) {
            return $articles;
            
        } else {
            return $this->limit($articles, $limit);
        }
    }

    /**
     * プレミアム記事とスタンダード記事のCollectionをマージする
     * 
     * @param Illuminate\Database\Eloquent\Collection $premiumArticles
     * @param Illuminate\Database\Eloquent\Collection $standardArticles
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function merge($premiumArticles, $standardArticles)
    {
        return $premiumArticles->concat($standardArticles);
    }

    /**
     * 記事を指定したカラムで降順ソートする
     * 
     * @param Illuminate\Database\Eloquent\Collection $articles
     * @param string $column 降順ソートするカラム
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function orderByDesc($articles, string $column)
    {
        return $articles->sortByDesc($column);
    }

    /**
     * 記事をcreated_atで降順ソートする
     * 
     * @param Illuminate\Database\Eloquent\Collection $articles
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function newly($articles)
    {
        return $this->orderByDesc($articles, 'created_at');
    }

    /**
     * 記事に紐付くショップIDでユニークにする
     * 
     * @param Illuminate\Database\Eloquent\Collection $articles
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function uniqueByShop($articles)
    {
        return $articles->unique(function ($article) {
            if ($article instanceof PremiumArticle) {
                return $article->{config('const.db.premium_articles.SHOP_ID')};
                
            } else if ($article instanceof StandardArticle) {
                return $article->{config('const.db.standard_articles.SHOP_ID')};
            }
        });
    }

    /**
     * 取得件数を指定する
     * 
     * @param Illuminate\Database\Eloquent\Collection $articles
     * @param $limit 取得件数
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function limit($articles, $limit)
    {
        return $articles->take($limit);
    }
}
