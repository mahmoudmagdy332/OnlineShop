<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LanguageRequest extends FormRequest
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
            'name'=>'required|string|max:100',
            'abbr'=>'required|string|max:10',

            'direction'=>'required|in:rtl,ltr'
        ];
    }
    public function messages()
    {
        return[
            'name.required'=>'حقل اللغة مطلوب',
            'name.string'=>' اسم اللغة يجب ان يكون احرف',
            'name.max'=>'اسم اللغة لابد ان لا يذيد عن 100',
            'abbr.required'=>'احقل الاختصار مطلوب',
            'abbr.string'=>'الاختصار  يجب ان يكون احرف',
            'abbr.max'=>'الاختصار لابد ان لا يذيد عن 10',
            'direction.in'=>'القيمة المدخلة غير صحيحة',

            'direction.required'=>'اتجاة اللغة مطلوب'

        ];
    }
}
