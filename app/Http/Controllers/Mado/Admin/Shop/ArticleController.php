<?php

namespace App\Http\Controllers\Mado\Admin\Shop;

use App\Facades\MadoLog;
use App\Http\Controllers\Controller;
use App\Http\Requests\Mado\Admin\Shop\ArticleRequest;
use App\Models\{
    Shop,
    StandardArticle
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ArticleController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index(Request $request, $shop_id)
    {
        // ショップを取得する
        $shop = Shop::find($shop_id);

        // 記事を取得
        $standardArticles = StandardArticle::shopId($shop_id)->orderByDesc(config('const.db.standard_articles.CREATED_AT'))->paginate(20);

        return view('mado.admin.shop.article.index', [
            'shop' => $shop,
            'standardArticles' => $standardArticles,
        ]);
    }

    public function new(Request $request, $shop_id)
    {
        // 新規インスタンスを渡す
        $standardArticle = new StandardArticle([config('const.db.standard_articles.SHOP_ID') => $shop_id]);

        return view('mado.admin.shop.article.edit', [
            'standardArticle' => $standardArticle,
            'mainPicture' => null,
        ]);
    }

    public function complete(ArticleRequest $request, $shop_id)
    {
        // 内容にmainタグ等が含まれているので除去する
        $matches = [];
        preg_match('/<div class="blogArea">(.+)<\/div>/us', $request->input(config('const.db.standard_articles.TEXT')), $matches);
        $text = $matches[1];

        // 内容には一旦空文字を挿入し、DBへ保存する。
        // 内容に画像が含まれる場合、画像がbase64に変換されて生データに含まれており、
        // データが長すぎてDBに保存できないため。
        $inputs = $request->all();
        $inputs[config('const.db.standard_articles.TEXT')] = '';

        try {
            // StandardArticleを取得し、入力データを格納する
            $standardArticle = StandardArticle::create($inputs);
            MadoLog::info('Ss017 スタンダード記事新規登録処理中、StandardArticleの作成に完了しました。');
        } catch (\Exception $e) {
            MadoLog::error('Sf017 スタンダード記事新規登録処理中、StandardArticleの作成に失敗しました。', ['error' => $e->getMessage()]);
            throw $e;
        }
        $articleId = $standardArticle->{config('const.db.standard_articles.ID')};

        // メイン画像を storage/app/public/shop/{shopId}/article/{articleId} に保存する
        $image = $request->file(config('const.form.admin.shop.standard_article.MAIN_PICTURE'));
        app()->make('image_edit')->setImage($image)->multipleResizeAndSave("shop/{$shop_id}/article/{$articleId}", 'main');

        // 内容に含まれる画像をストレージに保存し、内容中のbase64文字列を画像パスに置換する
        $standardArticle->{config('const.db.standard_articles.TEXT')} = app()->make('tinymce')->saveAll(
            $text,
            "shop/{$shop_id}/article/{$articleId}",
            config('const.db.standard_articles.TEXT') . '_'
        );

        // DB更新
        try {
            $standardArticle->save();
            MadoLog::info('Ss018 スタンダード記事更新処理中、StandardArticleの更新に完了しました。');
        } catch (\Exception $e) {
            MadoLog::error('Sf018 スタンダード記事更新処理中、StandardArticleの更新に失敗しました。', ['error' => $e->getMessage()]);
            throw $e;
        }

        // トークンをリフレッシュする
        $request->session()->regenerateToken();

        return redirect()->route('admin.shop.article', [
            'shop_id' => $shop_id
        ]);
    }

    public function edit(Request $request, $shop_id, $article_id)
    {
        // 記事を取得する
        $standardArticle = StandardArticle::find($article_id);

        return view('mado.admin.shop.article.edit', [
            'standardArticle' => $standardArticle,
            'mainPicture' => app()->make('image_get')->standardArticleMainUrl($article_id, 'l'),
        ]);
    }

    public function editComplete(ArticleRequest $request, $shop_id, $article_id)
    {
        // 新規画像がメイン写真に選択されていればストレージに保存する
        $image = $request->file(config('const.form.admin.shop.standard_article.MAIN_PICTURE'));
        if ($image !== null) {
            app()->make('image_edit')->setImage($image)->multipleResizeAndSave("shop/{$shop_id}/article/{$article_id}", 'main');
        }

        // 内容にmainタグ等が含まれているので除去する
        $matches = [];
        preg_match('/<div class="blogArea">(.+)<\/div>/us', $request->input(config('const.db.standard_articles.TEXT')), $matches);
        $text = $matches[1];
        
        // 内容に含まれる画像をストレージに保存し、内容中のbase64文字列を画像パスに置換する
        $newText = app()->make('tinymce')->saveDiff(
            $text,
            "shop/{$shop_id}/article/{$article_id}",
            config('const.db.standard_articles.TEXT') . '_'
        );
        
        // 入力データに上記内容を上書きする
        $data = $request->all();
        $data[config('const.db.standard_articles.TEXT')] = $newText;

        // 記事を取得し、入力データを格納する
        $standardArticle = StandardArticle::find($article_id)->fill($data);

        // DB更新
        try {
            $standardArticle->save();
            MadoLog::info('Ss019 スタンダード記事編集処理中、StandardArticleの更新に完了しました。');
        } catch (\Exception $e) {
            MadoLog::error('Sf019 スタンダード記事編集処理中、StandardArticleの更新に失敗しました。', ['error' => $e->getMessage()]);
            throw $e;
        }

        // トークンをリフレッシュする
        $request->session()->regenerateToken();

        return redirect()->route('admin.shop.article', ['shop_id' => $shop_id]);
    }

    public function delete(Request $request, $shop_id, $article_id)
    {
        $standardArticle = StandardArticle::find($article_id);
        if ($standardArticle !== null) {
            try {
                $standardArticle->delete();
                MadoLog::info('Ss020 スタンダード記事削除処理中、StandardArticleの削除に完了しました。');
            } catch (\Exception $e) {
                MadoLog::error('Sf020 スタンダード記事削除処理中、StandardArticleの削除に失敗しました。', ['error' => $e->getMessage()]);
                throw $e;
            }
        }

        return redirect()->route('admin.shop.article', ['shop_id' => $shop_id]);
    }
}
