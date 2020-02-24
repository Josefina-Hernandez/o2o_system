<?php

namespace App\Http\Requests\Mado\Admin\Shop;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

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
    public function rules()
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
            //Add edit start - BP_MMEN-23 - Hunglm - 20191125
            /*
            config('const.db.shops.OPEN_TIME') => 'required',
            config('const.db.shops.CLOSE_TIME') => 'required',
            config('const.db.shops.NORMALLY_CLOSE_DAY') => 'required',
            config('const.db.shops.SUPPORT_DETAIL_LIST') => 'required',
            */
            //Add edit end - BP_MMEN-23 - Hunglm - 20191125
            config('const.form.admin.shop.MAIN_PICTURE') => 'mimetypes:image/jpeg,image/png|between:0,' . config('const.common.image.FILE_SIZE'),
            config('const.db.shops.CAPITAL') => 'sometimes|nullable|numeric',
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

        //Add start Thanh Estimate 20191125
        if (\HelpersCart::is_general_site()) {
            $data = $this->request->all();
            if (($this->request->has(config('const.db.users.PASSWORD')) &&  $data[config('const.db.users.PASSWORD')] !== null )
                || ($this->request->has('password_new') && $data['password_new'] !== null )
                || ( $this->request->has('password_confirm') && $data['password_confirm'] !== null )) {
                $rules[config('const.db.users.PASSWORD')] = [
                    'required',
                    function ($attribute, $value, $fail) {
                        if (!\Hash::check($value, Auth::user()->password)) {
                            return $fail(__('現在のパスワードが正しくありません。'));
                        }
                    }

                ];
                $rules['password_new'] = [
                    'required',
                    'regex:/^[a-zA-Z\d@$.!%*#?& -]+$/',
                    'min:8'
                ];
                $rules['password_confirm'] = [
                    'required',
                    'regex:/^[a-zA-Z\d@$.!%*#?& -]+$/',
                    'same:password_new',
                    'min:8'
                ];
            }
        }
        //dd(1);
        //Add end Thanh Estimate 20191125
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

            config('const.db.users.PASSWORD') . ".required"=> "現在のパスワードは必ず選択してください。",
            "password_new.required"=> "新しいパスワードは必ず選択してください。",
            "password_new.min" => "パスワードは英数文字を使用し、８文字以上としてください。",
            
            "password_confirm.same"=> "新しいパスワードとパスワード確認が一致しません。",
            "password_confirm.required"=> "パスワード確認は必ず選択してください。",
            "password_confirm.min" => "パスワードは英数文字を使用し、８文字以上としてください。",
        ];
    }

    public function attributes()
    {
        return [
            config('const.db.shops.PREF_ID') => "都道府県",
            config('const.db.shops.CITY_ID') => "市区町村",
            config('const.db.shops.SUPPORT_DETAIL_LIST') => '取扱施工内容',
        ];
    }
}
