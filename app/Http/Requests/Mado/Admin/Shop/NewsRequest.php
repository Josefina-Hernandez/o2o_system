<?php

namespace App\Http\Requests\Mado\Admin\Shop;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
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
            config('const.db.standard_notices.PUBLISHED_AT') => 'required',
            config('const.db.standard_notices.TEXT') => 'required',
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
            config('const.db.emergency_messages.TEXT') => "内容",
        ];
    }
}
