<?php

namespace App\Http\Requests\Mado\Admin\Shop;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PhotoRequest extends FormRequest
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
            config('const.db.standard_photos.TITLE') => 'required',
            config('const.db.standard_photos.SUMMARY') => 'required',

            config('const.db.standard_photos.MAIN_TEXT') => 'required',
            config('const.form.admin.shop.standard_photo.MAIN_PICTURE') => ['mimetypes:image/jpeg,image/png', 'between:0,' . config('const.common.image.FILE_SIZE')],

            config('const.db.standard_photos.BEFORE_TEXT') => 'required',
            config('const.form.admin.shop.standard_photo.BEFORE_PICTURE') => ['mimetypes:image/jpeg,image/png', 'between:0,' . config('const.common.image.FILE_SIZE')],
            config('const.form.admin.shop.standard_photo.BEFORE_PICTURE_2') => ['mimetypes:image/jpeg,image/png', 'between:0,' . config('const.common.image.FILE_SIZE')],
            config('const.form.admin.shop.standard_photo.BEFORE_PICTURE_3') => ['mimetypes:image/jpeg,image/png', 'between:0,' . config('const.common.image.FILE_SIZE')],

            config('const.db.standard_photos.AFTER_TEXT') => 'required',
            config('const.form.admin.shop.standard_photo.AFTER_PICTURE') => ['mimetypes:image/jpeg,image/png', 'between:0,' . config('const.common.image.FILE_SIZE')],
            config('const.form.admin.shop.standard_photo.AFTER_PICTURE_2') => ['mimetypes:image/jpeg,image/png', 'between:0,' . config('const.common.image.FILE_SIZE')],
            config('const.form.admin.shop.standard_photo.AFTER_PICTURE_3') => ['mimetypes:image/jpeg,image/png', 'between:0,' . config('const.common.image.FILE_SIZE')],
            
            config('const.form.admin.shop.standard_photo.CUSTOMER_PICTURE') => ['mimetypes:image/jpeg,image/png', 'between:0,' . config('const.common.image.FILE_SIZE')],
            config('const.form.admin.shop.standard_photo.CUSTOMER_PICTURE_2') => ['mimetypes:image/jpeg,image/png', 'between:0,' . config('const.common.image.FILE_SIZE')],

            config('const.db.standard_photos.CATEGORY') => 'required',
            config('const.db.standard_photos.BUILT_YEAR') => 'required',
            config('const.db.standard_photos.PARTS') => 'required',
            config('const.db.standard_photos.REASON') => 'required',
            config('const.db.standard_photos.LOCALE') => 'required|max:20',
            config('const.db.standard_photos.BUDGET') => 'nullable|numeric|digits_between:1,4',
            config('const.db.standard_photos.PERIOD') => 'required|max:20',
            config('const.db.standard_photos.PRODUCT') => 'required|max:50',
            config('const.db.standard_photos.CATEGORY_FOR_SEARCH') => 'required',
        ];

        // キャッシュかストレージに画像がない場合、入力必須にする
        $token = Session::token();
        $photoId = $request->route('photo_id');
        $a = $photoId === null;
        if (app()->make('image_get')->cache($token . 'photo_main_l') === null
            && (($photoId === null) ? true : app()->make('image_get')->standardPhotoMainUrl($photoId, 'l') === null)) {
            $rules[config('const.form.admin.shop.standard_photo.MAIN_PICTURE')] = array_prepend($rules[config('const.form.admin.shop.standard_photo.MAIN_PICTURE')], 'required');
        }
        if (app()->make('image_get')->cache($token . 'photo_before') === null
            && (($photoId === null) ? true : app()->make('image_get')->standardPhotoBeforeUrl($photoId) === null)) {
            $rules[config('const.form.admin.shop.standard_photo.BEFORE_PICTURE')] = array_prepend($rules[config('const.form.admin.shop.standard_photo.BEFORE_PICTURE')], 'required');
        }
        if (app()->make('image_get')->cache($token . 'photo_after') === null
            && (($photoId === null) ? true : app()->make('image_get')->standardPhotoAfterUrl($photoId) === null)) {
            $rules[config('const.form.admin.shop.standard_photo.AFTER_PICTURE')] = array_prepend($rules[config('const.form.admin.shop.standard_photo.AFTER_PICTURE')], 'required');
        }

        // お客様の声掲載フラグがチェックされてる場合、テキストを必須にする
        if ($request->input(config('const.db.standard_photos.IS_CUSTOMER_PUBLISH')) == 1) {
            $rules[config('const.db.standard_photos.CUSTOMER_TEXT')] = 'required';
        }

        return $rules;
    }


    /**
     * エラーメッセージの指定
     *
     * @return array
     */
    public function messages()
    {
        return [
            config('const.form.admin.shop.standard_photo.MAIN_PICTURE') . ".required"   => ":attributeは必ず選択してください。",
            config('const.form.admin.shop.standard_photo.BEFORE_PICTURE') . ".required" => ":attributeは必ず選択してください。",
            config('const.form.admin.shop.standard_photo.AFTER_PICTURE') . ".required"  => ":attributeは必ず選択してください。",
            config('const.db.standard_photos.CATEGORY') . ".required"                   => ":attributeは必ず選択してください。",
            config('const.db.standard_photos.PARTS') . ".required"                      => ":attributeは必ず選択してください。",
            config('const.db.standard_photos.REASON') . ".required"                    => ":attributeは必ず選択してください。",
            config('const.db.standard_photos.CATEGORY_FOR_SEARCH') . ".required"        => ":attributeは必ず選択してください。",
        ];
    }

    /**
     * 属性の指定
     *
     * @return array
     */
    public function attributes()
    {
        return [
            config('const.form.admin.shop.standard_photo.MAIN_PICTURE')     => "メイン写真",
            config('const.form.admin.shop.standard_photo.BEFORE_PICTURE')   => "施工前写真",
            config('const.form.admin.shop.standard_photo.AFTER_PICTURE')    => "施工後写真",
        ];
    }
}
