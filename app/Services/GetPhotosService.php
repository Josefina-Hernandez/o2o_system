<?php

namespace App\Services;

use App\Models\{
    PremiumPhoto,
    StandardPhoto
};
use Illuminate\Database\Eloquent\Collection;

/**
 * 事例を取得するサービス
 */
class GetPhotosService
{
    /**
     * ステータスが公開である全ての事例を取得し、マージしてから最新順にソートする。
     * 
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function allPublicNewly()
    {
        $premiumPhotos = PremiumPhoto::isPublic()->get();
        $standardPhotos = StandardPhoto::isPublic()->get();

        $photos = $this->merge($premiumPhotos, $standardPhotos);
        return $this->newly($photos);
    }

    
    /**
     * お客様の声掲載フラグが無効になっている事例を取得し、
     * created_atでソートする。
     * 
     * @param $limit 取得件数
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function notHaveVoice($limit = null)
    {
        $premiumPhotos = PremiumPhoto::isPublic()->notHaveVoice()->get();
        $standardPhotos = StandardPhoto::isPublic()->notHaveVoice()->get();

        $photos = $this->merge($premiumPhotos, $standardPhotos);
        $photos = $this->newly($photos);
        $photos = $this->uniqueByShop($photos);

        if ($limit === null) {
            return $photos;
            
        } else {
            return $this->limit($photos, $limit);
        }
    }

    /**
     * お客様の声掲載フラグが有効になっている事例を取得し、
     * created_atでソートする。
     * 
     * @param $limit 取得件数
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function hasVoice($limit = null)
    {
        $premiumPhotos = PremiumPhoto::isPublic()->hasVoice()->get();
        $standardPhotos = StandardPhoto::isPublic()->hasVoice()->get();

        $photos = $this->merge($premiumPhotos, $standardPhotos);
        $photos = $this->newly($photos);
        $photos = $this->uniqueByShop($photos);

        if ($limit === null) {
            return $photos;
            
        } else {
            return $this->limit($photos, $limit);
        }
    }

    /**
     * プレミアム施工事例とスタンダード施工事例のCollectionをマージする
     * 
     * @param Illuminate\Database\Eloquent\Collection $premiumPhotos
     * @param Illuminate\Database\Eloquent\Collection $standardPhotos
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function merge($premiumPhotos, $standardPhotos)
    {
        return $premiumPhotos->concat($standardPhotos);
    }

    /**
     * 事例を指定したカラムで降順ソートする
     * 
     * @param Illuminate\Database\Eloquent\Collection $photos
     * @param string $column 降順ソートするカラム
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function orderByDesc($photos, string $column)
    {
        return $photos->sortByDesc($column);
    }

    /**
     * 事例をcreated_atで降順ソートする
     * 
     * @param Illuminate\Database\Eloquent\Collection $photos
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function newly($photos)
    {
        return $this->orderByDesc($photos, 'created_at');
    }

    /**
     * 事例に紐付くショップIDでユニークにする
     * 
     * @param Illuminate\Database\Eloquent\Collection $photos
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function uniqueByShop($photos)
    {
        return $photos->unique(function ($photo) {
            if ($photo instanceof PremiumPhoto) {
                return $photo->{config('const.db.premium_photos.SHOP_ID')};
                
            } else if ($photo instanceof StandardPhoto) {
                return $photo->{config('const.db.standard_photos.SHOP_ID')};
            }
        });
    }

    /**
     * 取得件数を指定する
     * 
     * @param Illuminate\Database\Eloquent\Collection $photos
     * @param $limit 取得件数
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function limit($photos, $limit)
    {
        return $photos->take($limit);
    }
}
