<?php

namespace App\Http\Controllers\Mado\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index(Request $request)
    {
        return view('mado.front.news.index');
    }

    public function detail($datetime)
    {
        $filePath = 'news_entry/' . $datetime;

        // ファイルが存在しなかった場合は404エラー
        if (! \File::exists(public_path($filePath . '.blade.php'))) {
            abort(404);
        }

        // お知らせ詳細bladeのDOMを取得
        $detail = app()->make('public_render')->render($filePath);

        return view('mado.front.news.detail', [
            'detail' => $detail
        ]);
    }
}
