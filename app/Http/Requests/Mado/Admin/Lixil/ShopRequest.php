<?php

namespace App\Http\Requests\Mado\Admin\Lixil;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ShopRequest extends FormRequest
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
            config('const.db.shops.COMPANY_NAME') => 'required',
            config('const.db.shops.COMPANY_NAME_KANA') => 'required',
            config('const.db.shops.NAME') => 'required',
            config('const.db.shops.KANA') => 'required',
            config('const.db.shops.ZIP1') => 'required',
            config('const.db.shops.ZIP2') => 'required',
            config('const.db.shops.PREF_ID') => 'required|numeric|min:1',
            config('const.db.shops.CITY_ID') => 'required|numeric|min:1',
            config('const.db.shops.STREET') => 'required',
            config('const.db.shops.EMAIL') => 'required|email',
            config('const.db.shops.OPEN_TIME') => 'required',
            config('const.db.shops.CLOSE_TIME') => 'required',
            config('const.db.shops.LATITUDE') => 'required',
            config('const.db.shops.LONGITUDE') => 'required',
            config('const.db.shops.NORMALLY_CLOSE_DAY') => 'required',
            config('const.db.shops.STANDARD_SHOP_PUBLISH_STATUS') => 'required',
            config('const.form.admin.lixil.shop.MAIN_PICTURE') => 'mimetypes:image/jpeg,image/png|between:0,' . config('const.common.image.FILE_SIZE'),
            config('const.db.shops.CAPITAL') => 'sometimes|nullable|numeric',
            config('const.db.shops.SUPPORT_DETAIL_LIST') => 'required',
        ];

        // 電話番号とFAX番号は {半角数字2-4桁}-{半角数字2-4桁}-{半角数字3-4桁} の形式にする
        $rules[config('const.db.shops.TEL')] = [
            'required',
            'regex:/^[0-9]{2,4}-[0-9]{2,4}-[0-9]{3,4}$/',
        ];
        $rules[config('const.db.shops.FAX')] = [
            'required',
            'regex:/^[0-9]{2,4}-[0-9]{2,4}-[0-9]{3,4}$/',
        ];

        // 新規登録時のみプランとショップコードにバリデーションをかける
        if ('admin.lixil.shop.confirm' === \Route::currentRouteName()) {
            // プラン
            $rules[config('const.db.shops.SHOP_CLASS_ID')] = 'required';

            // ショップコードは半角英数字とハイフンのみを認める。
            // また、都道府県IDとショップコードが一意である制約をかける。
            // 更に、編集時の対応として自分のショップIDを一意制約の対象から除く。
            $rules[config('const.db.shops.SHOP_CODE')] = [
                    'required',
                    'regex:/^[0-9a-z-]+$/',
                    Rule::unique('shops')->ignore($request->route('shop_id'))->where(function ($query) use ($request) {
                        $query
                            ->where(config('const.db.shops.PREF_ID'), $request->{config('const.db.shops.PREF_ID')})
                            ->where(config('const.db.shops.SHOP_CODE'), $request->{config('const.db.shops.SHOP_CODE')});
                    })
            ];
        }

        // プレミアムショップドメインはプレミアムショップ公開フラグが公開の場合に必須とする。
        if ($request->input(config('const.db.shops.IS_PUBLISHED_PREMIUM')) == 3) {
            $rules[config('const.db.shops.PREMIUM_SHOP_DOMAIN')] = 'required';
        }

        return $rules;
    }

    /**
     * エラーメッセージ
     */
    public function messages()
    {
        return 
        [
            config('const.db.shops.PREF_ID') . ".numeric"=> ":attributeは必ず選択してください。",
            config('const.db.shops.PREF_ID') . ".required"=> ":attributeは必ず選択してください。",
            config('const.db.shops.PREF_ID') . ".min"=> ":attributeは必ず選択してください。",
            config('const.db.shops.CITY_ID') . ".numeric"=> ":attributeは必ず選択してください。",
            config('const.db.shops.CITY_ID') . ".required"=> ":attributeは必ず選択してください。",
            config('const.db.shops.CITY_ID') . ".min"=> ":attributeは必ず選択してください。",
        ];  
    }

    /**
     * 
     */
    public function attributes()
    {
        return [
            config('const.db.shops.PREF_ID') => "都道府県",
            config('const.db.shops.CITY_ID') => "市区町村",
            config('const.db.shops.SHOP_CODE') => "店舗URL",
            config('const.db.shops.SUPPORT_DETAIL_LIST') => '取扱施工内容',
        ];
    }
}
