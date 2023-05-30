<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class loginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'userName'=> ['required','exists:admins'],
            'password'=>['required']
        ];
    }
    public function messages(): array
{
    return [
        'userName.required' => 'A User Name is required',
        'userName.exists' => "Email doesn't exists",
        'password.required' => 'A Password is required',
    ];
}
}
