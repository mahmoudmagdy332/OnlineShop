<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Main_catigoriesRequest extends FormRequest
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
            'photo'=>'required_without:id|mimes:jpj,jpeg,png',
            'categories'=>'array|min:1',
            'categories.*.name'=>"required|string|max:100"
        ];
    }
    public function messages()
    {
        return[
            'photo.required_without'=>'ادخل صورة القسم',
             'photo.mimes'=>'امتداد الفايل لابد "jpj,jpeg,png"',
            'categories.required'=>'ادخل قسم واحد على الاقل',
            'categories.*.name.required'=>'حقل الاسم مطلوب',
            'categories.*.name.string'=>'حقل الاسم يجب ان يكون احرف',
            'categories.*.name.max'=>' الاسم يجب ان يكون اقل من 100',
        ];
    }
}
