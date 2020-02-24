<?php

namespace App\Services;

use Illuminate\Container\Container;
use Illuminate\Contracts\Filesystem\Factory as FilesystemFactory;
use Illuminate\Support\Facades\{
    Cache,
    File,
    Storage
};
use Intervention\Image\ImageManagerStatic as Image;

/**
 * 画像に関する機能を提供するクラス
 * 
 */
class ImageEditService
{
    /**
     * @var Intervention\Image\Image
     */
    private $image;

    /**
     * @var Illuminate\Filesystem\FilesystemAdapter
     */
    private $adapter;

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
     * 処理対象となる画像をセットする
     * 
     * @param $image 画像ファイル
     * @return App\Services\ImageEditService
     */
    public function setImage($image)
    {
        $this->image = Image::make($image);

        return $this;
    }

    /**
     * 画像のリサイズを行う。
     * 
     * @return App\Services\ImageEditService
     */
    public function resize(int $width, int $height)
    {
        $this->image->resize($width, $height);

        return $this;
    }

    /**
     * サイズ名を指定して画像のリサイズを行う
     * サイズ名と長辺の最大長の組み合わせは config/const.php で定義する。
     */
    public function resizeTo(string $sizeName)
    {
        $lengths = config('const.common.image.MAX_LENGTHS');

        if (! array_key_exists($sizeName, $lengths)) {
            // 存在しないサイズ名を指定した場合はリサイズを行わない
            return $this;
        }

        // configから最大長を取得する
        $maxLength = $lengths[$sizeName];

        // オリジナル画像の長辺を取得する
        $width = (int)$this->image->width();
        $height = (int)$this->image->height();
        $longest = ($height > $width) ? $height : $width;
        
        if ($longest > $maxLength) {
            // 画像の長辺が最大長より大きいので、縮小割合を計算する
            $ratio = (float)($maxLength / $longest);

        } else {
            // 画像の長辺が最大長以下に収まっているので、縮小しない
            $ratio = 1.0;
        }

        // 画像のリサイズを行う
        return $this->resize((int)($width * $ratio), (int)($height * $ratio));
    }

    /**
     * 画像のエンコードを行う。
     * 
     * @param string $format 画像のフォーマット
     * @param int $quality 画像の品質
     */
    public function encode(string $format = 'jpg', int $quality = 70)
    {
        $this->image->encode($format, $quality);

        return $this;
    }

    /**
     * 画像をサーバーのストレージに保存する。
     * storage/app/public/{$directory}/{$fileName}.jpg
     * 
     * @param string $directory 保存配下のディレクトリ
     * @param string $fileName 保存後のファイル名
     * @return string 画像のURL
     */
    public function save(string $directory, string $fileName)
    {
        $path = $this->publicPath . $directory . $this->dirSeparator . $fileName . '.jpg';

        // ディレクトリがなかった場合は作成する
        if (! is_writable($this->publicPath . $directory)) {
            File::makeDirectory($this->publicPath . $directory, 0755, true);
        }

        // 画像の保存
        $this->image->save($path, config('const.common.image.ENCODE_QUALITY'));

        // DIRECTORY_SEPARATORではなく、明示的に / に変換する
        $resultPath = preg_replace('/\\\\/', '/', $directory . $this->dirSeparator . $fileName . '.jpg');

        // フルパスのURLを返す
        return asset(Storage::url($resultPath));
    }

    /**
     * ストレージに保存されている画像の削除を行う。
     * storage/app/public/{$directory}/{$fileName}.jpg
     */
    public function delete(string $directory, string $fileName)
    {
        $path = $directory . $this->dirSeparator . $fileName . '.jpg';
        
        // ファイルが存在していれば削除する
        if (app()->make('image_get')->exists($path)) {
            Storage::delete('public/' . $path);
        }

    }

    /**
     * config/const.phpに記載されたサイズ名と最大長を取得し、
     * 定義されているサイズ分だけリサイズと保存処理を行う。
     * 
     * resize()とsave()のラップ関数。
     * 
     * @param string $directory 保存配下のディレクトリ
     * @param string $fileName 保存後のファイル名
     * @return array サイズ名をkeyに、保存に成功すればURL、失敗ならfalseをvalueとする配列
     */
    public function multipleResizeAndSave(string $directory, string $fileName)
    {
        // サイズ名を取得する
        $sizeNames = array_keys(config('const.common.image.MAX_LENGTHS'));

        $result = [];
        foreach ($sizeNames as $sizeName) {
            // 初期状態を保持しておく
            $this->image->backup();

            // 画像のリサイズを行う
            $this->resizeTo($sizeName);

            // 画像を保存する
            $result[$sizeName] = $this->save($directory, "{$fileName}_{$sizeName}");

            // 画像の状態を初期状態に戻す
            $this->image->reset();
        }

        return $result;
    }

    /**
     * 画像をサーバーのキャッシュとして保存する。
     * 
     * @param string $key キャッシュのキー
     */
    public function cache(string $key)
    {
        Cache::put($key, $this->image, config('cache.lifetime'));
    }

    /**
     * config/const.phpに記載されたサイズ名と最大長を取得し、
     * 定義されているサイズ分だけリサイズと保存処理を行う。
     * 
     * resize()とcache()のラップ関数。
     * 
     * @param string $key キャッシュのキー
     */
    public function multipleCache(string $key)
    {
        // サイズ名を取得する
        $sizeNames = array_keys(config('const.common.image.MAX_LENGTHS'));

        foreach ($sizeNames as $sizeName) {
            // 初期状態を保持しておく
            $this->image->backup();

            // 画像のリサイズを行う
            $this->resizeTo($sizeName)->encode('jpg',  config('const.common.image.ENCODE_QUALITY'));

            // 画像をキャッシュに保存する
            $this->cache("{$key}_{$sizeName}");

            // 画像の状態を初期状態に戻す
            $this->image->reset();
        }
    }

    /**
     * 指定されたキーのキャッシュを削除する
     * 
     * @param string $key キャッシュのキー
     */
    public function cacheDelete(string $key)
    {
        Cache::forget($key); 
    }

    /**
     * キャッシュに保存されている画像をストレージに保存する
     * 
     * @param string $cacheKey ストレージに保存したいキャッシュのキー
     * @param string $directory 保存配下のディレクトリ
     * @param string $fileName 保存後のファイル名
     * @return string|null 画像のURL
     */
    public function cacheToStorage(string $cacheKey, string $directory, string $fileName)
    {
        // キャッシュから取得する
        $image = app()->make('image_get')->cache($cacheKey);

        // キャッシュに存在しなかった場合はnullを返却する
        if ($image === null) return null;

        // 画像をストレージに保存する
        return $this->setImage($image)->save($directory, $fileName);
    }
}
