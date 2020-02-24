<?php

namespace App\Http\Requests\Mado\Admin\Shop;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class StaffRequest extends FormRequest
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
            $name = array_get($data, config('const.db.staffs.NAME') . '_' . $rank, null);
            if ($name !== null) {
                // 名前が入力されている場合、挨拶と画像を入力必須にする
                $rules[config('const.db.staffs.MESSAGE') . '_' . $rank] = 'required';
                $rules[config('const.form.admin.shop.staff.PICTURE') . '_' . $rank] = [
                    'mimetypes:image/jpeg,image/png',
                    'between:0,' . config('const.common.image.FILE_SIZE')
                ];

                // 画像はストレージに存在しない時に入力必須にする
                if (! app()->make('image_get')->exists("shop/{$shopId}/staff/staff_{$rank}.jpg")) {
                    $rules[config('const.form.admin.shop.staff.PICTURE') . '_' . $rank][] = 'required';
                }
            }
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
        $messages = [];
        foreach (range(1, 5) as $rank) {
            $messages = $messages + [
                config('const.form.admin.shop.staff.PICTURE') . '_' . $rank . ".required" => ":attributeは必ず選択してください。"
            ];
        }
        return $messages;
    }

    /**
     * 属性の指定
     *
     * @return array
     */
    public function attributes()
    {
        $attributes = [];
        foreach (range(1, 5) as $rank) {
            $attributes = $attributes + [
                config('const.db.staffs.MESSAGE') . '_' . $rank             => "メッセージ",
                config('const.form.admin.shop.staff.PICTURE') . '_' . $rank => "写真"
            ];
        }
        return $attributes;
    }
}
