<?php

namespace App\Http\Requests\Mado\Admin\Shop;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        $rules = [
            config('const.db.standard_articles.CATEGORY') => 'required',
            config('const.db.standard_articles.PUBLISHED_AT') => 'required',
            config('const.db.standard_articles.TITLE') => 'required',
            config('const.form.admin.shop.standard_article.MAIN_PICTURE') => ['mimetypes:image/jpeg,image/png', 'between:0,' . config('const.common.image.FILE_SIZE')],
            config('const.db.standard_articles.SUMMARY') => 'required',
        ];

        // ストレージに画像がない場合、入力必須にする
        $articleId = $request->route('article_id');
        if ($articleId === null
            || ($articleId !== null 
                && app()->make('image_get')->standardArticleMainUrl($articleId, 'l') === null)
            ) {
            // 新規投稿画面か、編集画面であればストレージに画像がない
            $rules[config('const.form.admin.shop.standard_article.MAIN_PICTURE')] = array_prepend($rules[config('const.form.admin.shop.standard_article.MAIN_PICTURE')], 'required');
        }

        return $rules;
    }

    /**
     * エラーメッセージを指定する
     */
    public function messages()
    {
        return
            [
                config('const.db.standard_articles.CATEGORY') . ".required" => ":attributeは必ず選択してください。",
                config('const.form.admin.shop.standard_article.MAIN_PICTURE') . ".required" => ":attributeは必ず選択してください。",
            ];
    }

    /**
     * 属性を指定する
     */
    public function attributes()
    {
        return [
            config('const.db.standard_articles.CATEGORY') => "カテゴリ",
            config('const.db.standard_articles.PUBLISHED_AT') => "年月日",
            config('const.form.admin.shop.standard_article.MAIN_PICTURE') => 'メイン写真',
            config('const.db.standard_articles.TEXT') => "内容",
        ];
    }
}
