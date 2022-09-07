<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
         'username'=>'required',
         'password'=>'required',
        ];
    }

    public function messages()
    {
        return [
        'username.required'=>'اسم المستخدم مطلوب',
        'password.required'=>'كلمة المرور مطلوبة'    
        ];
    }
}
