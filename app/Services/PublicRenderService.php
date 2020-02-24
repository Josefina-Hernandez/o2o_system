<?php

namespace App\Services;

use Illuminate\Support\Facades\View;
use Illuminate\View\FileViewFinder;

/**
 * public配下のbladeをレンダーするクラス
 */
class PublicRenderService
{
    /**
     * public配下にあるbladeをレンダーし、DOM文字列を返却する
     * 
     * @param string $filePath /public/{$filePath}で表せられるbladeのパス, .blade.php は含まない
     * @return string
     */
    public function render(string $filePath)
    {
        // 元々のfinderを取得しておく
        $originalFinder = View::getFinder();

        // /public をホームディレクトリとするようにfinderの設定
        $path = [public_path()];
        $finder = new FileViewFinder(app()->files, $path);
        View::setFinder($finder);
 
        // 一旦レンダーし、文字列としてDOMを取得
        $dom = View::make($filePath)->render();
 
        // finderを元に戻す
        View::setFinder($originalFinder);

        return $dom;
    }
}