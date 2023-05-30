<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VendorRequest extends FormRequest
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
            'logo'=>'required_without:id|mimes:jpj,jpeg,png',
            'name'=>'required|string|max:100',
            'mobile'=>'required|max:100',
            'email'=>'required|max:100|email|unique:vendors,email,'.$this->id,
            'password'=>'required_without:id|max:100',
            'address'=>"required|string|max:500"
        ];
    }
    public function messages()
    {
        return[
            'logo.required_without'=>'ادخل اللوجو القسم',
            'photo.mimes'=>'امتداد الفايل لابد "jpj,jpeg,png"',
            'required'=>'هذا الحقل مطلوب ',
            'string'=>'هذا الحقل يجب ان يكون احرف',
            'max'=>'هذا الحقل يجب ان يكون اقل من 100',
            'password.min'=>'كلمة السر ضعيفة',
            'unique'=>'البريد الاليكترونى موجود بالفعل'
        ];
    }
}
