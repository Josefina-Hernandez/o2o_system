<?php

namespace App\Http\Requests\Mado\Front;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
        return [
            config('const.form.front.standard.contact.NAME1') => 'required',
            config('const.form.front.standard.contact.NAME2') => 'required',
            config('const.form.front.standard.contact.KANA1') => 'required',
            config('const.form.front.standard.contact.KANA2') => 'required',
            config('const.form.front.standard.contact.CONTACT_WAY') => 'required',
            config('const.form.front.standard.contact.EMAIL') => 'required',
            config('const.form.front.standard.contact.TEL') => 'required',
            config('const.form.front.standard.contact.ADDRESS') => 'required',
            config('const.form.front.standard.contact.CONTACT_CATEGORY') => 'required',
            config('const.form.front.standard.contact.CONTACT_TEXT') => 'required',
            config('const.form.front.standard.contact.CONTACT_PRIVACY') => 'required',
        ];
    }

    public function attributes(){
        return [

            config('const.form.front.standard.contact.NAME1') => 'お名前（姓）',
            config('const.form.front.standard.contact.NAME2') => 'お名前（名）',
            config('const.form.front.standard.contact.KANA1') => 'フリガナ（姓）',
            config('const.form.front.standard.contact.KANA2') => 'フリガナ（名）',
            config('const.form.front.standard.contact.CONTACT_WAY') => 'ご連絡方法',
            config('const.form.front.standard.contact.ADDRESS') => '住所',
            
            config('const.form.front.standard.contact.CONTACT_PRIVACY') => 'プライバシーポリシー',
            config('const.form.front.standard.contact.CONTACT_CATEGORY') => 'お問い合わせ内容',
            config('const.form.front.standard.contact.CONTACT_TEXT') => 'ご相談内容',
        ];
    }
    public function messages(){
        return [
            config('const.form.front.standard.contact.CONTACT_PRIVACY') ."required" => ":attributeの同意は必ずチェックしてください。"
        ];
    }

}
