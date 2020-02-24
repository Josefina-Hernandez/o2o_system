<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use function GuzzleHttp\Psr7\str;

/**
 * TinyMCE関連の機能を提供するクラス
 */
class TinyMceService
{
    /**
     * TinyMCEから受け取った文字列からbase64エンコードされた画像を抽出し、
     * デコードした後にストレージに保存してから文字列中の画像をパスに変換する。
     */
    public function saveAll(string $content, string $directory, string $prefix = '')
    {
        // base64エンコードされた文字列を抽出する
        return preg_replace_callback('/src="(?:data:image\/(?:png|jpeg);base64,([a-zA-Z0-9\/+=]+))"/', function ($matches) use ($directory, $prefix) {
            // 画像をストレージに保存する
            $url = app()->make('image_edit')->setImage($matches[1])->save($directory, $prefix . str_random(20));
            
            // 画像のパスに置換する
            return "src=\"{$url}\"";
        }, $content);
    }

    /**
     * TinyMCEから受け取った文字列（新コンテンツ）と過去に保存されたデータ（旧コンテンツ）を比較し、
     * 新コンテンツに含まれて旧コンテンツに含まれない画像データをストレージに保存する。
     * また、旧コンテンツに含まれて新コンテンツにない画像データをストレージから削除する。
     */
    public function saveDiff(string $newContent, string $directory, string $prefix = '')
    {
        // ストレージに保存されている画像パスを全て取得する
        $oldFilePaths = Storage::files('public/' . $directory);
        $oldFileNames = array_map(function ($name) {
            $pos = mb_strrpos($name, '/', 0, 'UTF-8');
            return mb_substr($name, $pos + 1, null, 'UTF-8');
        }, $oldFilePaths);

        // $prefixから始まるファイル名だけを抽出する
        $oldFileNames = array_where($oldFileNames, function ($name) use ($prefix) {
            return starts_with($name, $prefix);
        });
        
        // ストレージに保存されていて新コンテンツに含まれていない画像パスを削除する
        foreach ($oldFileNames as $oldName) {
            if (! str_contains($newContent, $oldName)) {
                // 画像の削除
                app()->make('image_edit')->delete($directory, str_before($oldName, '.jpg'));
            }
        }

        // 新コンテンツに含まれて旧コンテンツに含まれない画像データをストレージに画像として保存する。
        // 当該データは新コンテンツ中にbase64文字列として含まれているため、saveAllを通す。
        return $this->saveAll($newContent, $directory, $prefix);
    }
}
