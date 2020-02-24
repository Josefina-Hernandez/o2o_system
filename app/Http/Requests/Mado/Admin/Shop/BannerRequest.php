<?php

namespace App\Http\Requests\Mado\Admin\Shop;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class BannerRequest extends FormRequest
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
        $rules = [];

        $data = $request->all();
        $shopId = $request->route('shop_id');
        foreach (range(1, 5) as $rank) {
            $url = array_get($data, config('const.db.banners.URL') . '_' . $rank, null);
            $picture = $request->file(config('const.form.admin.shop.banner.PICTURE') . '_' . $rank);

            if ($url !== null || $picture !== null) {
                // URLを必須入力とする
                $rules[config('const.db.banners.URL') . '_' . $rank] = 'required';

                // 画像の形式とサイズを指定する
                $rules[config('const.form.admin.shop.banner.PICTURE') . '_' . $rank] = [
                    'mimetypes:image/jpeg,image/png',
                    'between:0,' . config('const.common.image.FILE_SIZE')
                ];

                // 画像はストレージに存在しない時に入力必須にする
                if (! app()->make('image_get')->exists("shop/{$shopId}/banner/banner_{$rank}.jpg")) {
                    $rules[config('const.form.admin.shop.banner.PICTURE') . '_' . $rank][] = 'required';
                }
            }
        }

        return $rules;
    }

    public function attributes()
    {
        $attributes = [];

        foreach (range(1, 5) as $rank) {
            $attributes[config('const.db.banners.URL') . '_' . $rank] = 'URL';
            $attributes[config('const.form.admin.shop.banner.PICTURE') . '_' . $rank] = 'バナー画像';
        }

        return $attributes;
    }
}
