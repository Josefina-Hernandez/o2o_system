<?php

namespace App\Services;

use Illuminate\Container\Container;
use Illuminate\Contracts\Filesystem\Factory as FilesystemFactory;
use Illuminate\Support\Facades\{
    Cache,
    File,
    Storage
};
use App\Models\{
    StandardArticle,
    StandardPhoto
};

/**
 * 画像を取得するためのクラス
 * 
 */
class ImageGetService
{
    /**
     * 保存先のpublicを示すフルパス
     * 末端にセパレータを含む。
     * 
     * @var string
     */
    private $publicPath;

    /**
     * @var string
     */
    private $dirSeparator = DIRECTORY_SEPARATOR;

    public function __construct()
    {
        // config/filesystem.phpの設定に依存させるため、adapter経由でパスを取得する
        // 参考: \Illuminate\Http\UploadedFile::storeAs()
        $this->adapter = Container::getInstance()->make(FilesystemFactory::class)->disk('public');

        // 保存先のパスを決定する
        $this->publicPath = preg_replace('/\\//', $this->dirSeparator, $this->adapter->path(''));
    }

    /**
     * キャッシュから画像を取得する
     * 
     * @param string $key キャッシュのキー
     * @return string 画像データ
     */
    public function cache(string $key)
    {
        $image = Cache::get($key);
        return $image !== null ? $image->encoded : null;
    }

    /**
     * キャッシュからbase64エンコードされた画像を取得する
     * 
     * @param string $key キャッシュのキー
     * @param string $prefix base64文字列に付与する接頭辞
     * @return string 画像データ
     */
    public function cacheToBase64(string $key, string $prefix = 'data:image/jpeg;base64,')
    {
        $image = $this->cache($key);
        return $image !== null ? $prefix . base64_encode($image) : null;
    }

    /**
     * storage/publicを起点とするパスを渡し、画像が存在するかどうかを確かめる
     * 拡張子まで$pathに含める必要がある。
     * 
     * @param string 画像のパス
     * @return boolean
     */
    public function exists(string $path)
    {
        return File::exists($this->publicPath . $path);
    }

    /**
     * storage/publicを起点とするパスを渡し、画像のURLに変換する。
     * 渡されたパスに画像が存在しない場合、nullを返却する。
     * 
     * @param string 画像のパス
     * @return null|string 画像のURL
     */
    public function path(string $path)
    {
        // ファイルが存在しなければnullを返す
        if (! $this->exists($path)) {
            return null;
        }

        // DIRECTORY_SEPARATORではなく、明示的に / に変換する
        $resultPath = preg_replace('/\\\\/', '/', $path);
        
        // フルパスのURLを返す
        return asset(Storage::url($resultPath));
    }

    /**
     * ダミー画像のURLを返却する
     * 
     * @return string
     */
    public function dummy()
    {
        return asset('img/dummy.png');
    }

    /**
     * プレミアムサイトが同期した施工事例, 現場ブログ, イベントキャンペーンの、
     * アイキャッチ画像のダミーURLを返却する。
     */
    public function dummyFeaturedImage()
    {
        return asset('img/dummy_featured.png');
    }

    /**
     * ショップIDとサイズ名を指定し、ショップのメイン画像を取得する
     * /shop/{shop_id}/main_{$sizeName}.jpg
     * 
     * @param $shopId ショップID
     * @param string $sizeName サイズ名
     * @param boolean $withDummy 指定したサイズの画像がなければダミー画像を返却するようにするかどうか
     * @return string|null
     */
    public function shopMainUrl($shopId, string $sizeName, bool $withDummy = true)
    {
        $path = "shop{$this->dirSeparator}{$shopId}{$this->dirSeparator}main_{$sizeName}.jpg";

        $a = $this->path($path);

        if ($withDummy) {
            return $this->path($path) ?? $this->dummy();
        } else {
            return $this->path($path);
        }
    }

    /**
     * スタンダード事例IDとサイズ名を指定し、スタンダード事例のメイン画像を取得する
     * /shop/{shop_id}/photo/{$photoId}/main_{$sizeName}.jpg
     * 
     * @param $photoId スタンダード事例ID
     * @param string $sizeName サイズ名
     * @return string|null
     */
    public function standardPhotoMainUrl($photoId, string $sizeName)
    {
        // ショップIDを取得する
        $shopId = (StandardPhoto::find($photoId))->{config('const.db.standard_photos.SHOP_ID')};

        $path = "shop{$this->dirSeparator}{$shopId}{$this->dirSeparator}photo{$this->dirSeparator}{$photoId}{$this->dirSeparator}main_{$sizeName}.jpg";

        return $this->path($path);
    }

    /**
     * スタンダード事例IDを指定し、スタンダード事例の施工前写真1を取得する
     * /shop/{shop_id}/photo/{$photoId}/before.jpg
     * 
     * @param $photoId スタンダード事例ID
     * @return string|null
     */
    public function standardPhotoBeforeUrl($photoId)
    {
        // ショップIDを取得する
        $shopId = (StandardPhoto::find($photoId))->{config('const.db.standard_photos.SHOP_ID')};

        $path = "shop{$this->dirSeparator}{$shopId}{$this->dirSeparator}photo{$this->dirSeparator}{$photoId}{$this->dirSeparator}before.jpg";

        return $this->path($path);
    }

    /**
     * スタンダード事例IDを指定し、スタンダード事例の施工前写真2を取得する
     * /shop/{shop_id}/photo/{$photoId}/before_2.jpg
     * 
     * @param $photoId スタンダード事例ID
     * @return string|null
     */
    public function standardPhotoBefore2Url($photoId)
    {
        // ショップIDを取得する
        $shopId = (StandardPhoto::find($photoId))->{config('const.db.standard_photos.SHOP_ID')};

        $path = "shop{$this->dirSeparator}{$shopId}{$this->dirSeparator}photo{$this->dirSeparator}{$photoId}{$this->dirSeparator}before_2.jpg";

        return $this->path($path);
    }

    /**
     * スタンダード事例IDを指定し、スタンダード事例の施工前写真3を取得する
     * /shop/{shop_id}/photo/{$photoId}/before_3.jpg
     * 
     * @param $photoId スタンダード事例ID
     * @return string|null
     */
    public function standardPhotoBefore3Url($photoId)
    {
        // ショップIDを取得する
        $shopId = (StandardPhoto::find($photoId))->{config('const.db.standard_photos.SHOP_ID')};

        $path = "shop{$this->dirSeparator}{$shopId}{$this->dirSeparator}photo{$this->dirSeparator}{$photoId}{$this->dirSeparator}before_3.jpg";

        return $this->path($path);
    }

    /**
     * スタンダード事例IDを指定し、スタンダード事例の施工後写真1を取得する
     * /shop/{shop_id}/photo/{$photoId}/after.jpg
     * 
     * @param $photoId スタンダード事例ID
     * @return string|null
     */
    public function standardPhotoAfterUrl($photoId)
    {
        // ショップIDを取得する
        $shopId = (StandardPhoto::find($photoId))->{config('const.db.standard_photos.SHOP_ID')};

        $path = "shop{$this->dirSeparator}{$shopId}{$this->dirSeparator}photo{$this->dirSeparator}{$photoId}{$this->dirSeparator}after.jpg";

        return $this->path($path);
    }

    /**
     * スタンダード事例IDを指定し、スタンダード事例の施工後写真2を取得する
     * /shop/{shop_id}/photo/{$photoId}/after_2.jpg
     * 
     * @param $photoId スタンダード事例ID
     * @return string|null
     */
    public function standardPhotoAfter2Url($photoId)
    {
        // ショップIDを取得する
        $shopId = (StandardPhoto::find($photoId))->{config('const.db.standard_photos.SHOP_ID')};

        $path = "shop{$this->dirSeparator}{$shopId}{$this->dirSeparator}photo{$this->dirSeparator}{$photoId}{$this->dirSeparator}after_2.jpg";

        return $this->path($path);
    }

    /**
     * スタンダード事例IDを指定し、スタンダード事例の施工後写真3を取得する
     * /shop/{shop_id}/photo/{$photoId}/after_3.jpg
     * 
     * @param $photoId スタンダード事例ID
     * @return string|null
     */
    public function standardPhotoAfter3Url($photoId)
    {
        // ショップIDを取得する
        $shopId = (StandardPhoto::find($photoId))->{config('const.db.standard_photos.SHOP_ID')};

        $path = "shop{$this->dirSeparator}{$shopId}{$this->dirSeparator}photo{$this->dirSeparator}{$photoId}{$this->dirSeparator}after_3.jpg";

        return $this->path($path);
    }

    /**
     * スタンダード事例IDを指定し、スタンダード事例のお客様の声画像（写真1）を取得する
     * /shop/{shop_id}/photo/{$photoId}/customer.jpg
     * 
     * @param $photoId スタンダード事例ID
     * @return string|null
     */
    public function standardPhotoCustomerUrl($photoId)
    {
        // ショップIDを取得する
        $shopId = (StandardPhoto::find($photoId))->{config('const.db.standard_photos.SHOP_ID')};

        $path = "shop{$this->dirSeparator}{$shopId}{$this->dirSeparator}photo{$this->dirSeparator}{$photoId}{$this->dirSeparator}customer.jpg";

        return $this->path($path);
    }

    /**
     * スタンダード事例IDを指定し、スタンダード事例のお客様の声画像（写真2）を取得する
     * /shop/{shop_id}/photo/{$photoId}/customer_2.jpg
     * 
     * @param $photoId スタンダード事例ID
     * @return string|null
     */
    public function standardPhotoCustomer2Url($photoId)
    {
        // ショップIDを取得する
        $shopId = (StandardPhoto::find($photoId))->{config('const.db.standard_photos.SHOP_ID')};

        $path = "shop{$this->dirSeparator}{$shopId}{$this->dirSeparator}photo{$this->dirSeparator}{$photoId}{$this->dirSeparator}customer_2.jpg";

        return $this->path($path);
    }

    /**
     * ショップIDと並び順を指定し、スタッフ画像を取得する
     * /shop/{shop_id}/staff/staff_{rank}.jpg
     * 
     * @param $shopId ショップID
     * @param $rank 並び順
     * @return string|null
     */
    public function staffUrl($shopId, $rank)
    {
        $path = "shop{$this->dirSeparator}{$shopId}{$this->dirSeparator}staff{$this->dirSeparator}staff_{$rank}.jpg";

        return $this->path($path);
    }

    /**
     * ショップIDと並び順を指定し、バナー画像を取得する
     * /shop/{shop_id}/banner/banner_{rank}.jpg
     * 
     * @param $shopId ショップID
     * @param $rank 並び順
     * @return string|null
     */
    public function bannerUrl($shopId, $rank)
    {
        $path = "shop{$this->dirSeparator}{$shopId}{$this->dirSeparator}banner{$this->dirSeparator}banner_{$rank}.jpg";

        return $this->path($path);
    }

    /**
     * スタンダード記事（現場ブログ/イベントキャンペーン）のIDとサイズ名を指定し、スタンダード記事のメイン画像を取得する
     * /shop/{shop_id}/article/{$articleId}/main_{$sizeName}.jpg
     * 
     * @param $articleId スタンダード記事ID
     * @param string $sizeName サイズ名
     * @return string|null
     */
    public function standardArticleMainUrl($articleId, string $sizeName)
    {
        // ショップIDを取得する
        $shopId = (StandardArticle::find($articleId))->{config('const.db.standard_articles.SHOP_ID')};

        $path = "shop{$this->dirSeparator}{$shopId}{$this->dirSeparator}article{$this->dirSeparator}{$articleId}{$this->dirSeparator}main_{$sizeName}.jpg";

        return $this->path($path);
    }
}
