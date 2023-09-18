<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
            'name' => 'required',
            'permission_roles_id' => 'required',
            'username' => 'required',
            'email' => 'email',
            'password' => 'required',
            'active' => 'required',

        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'اسم المستخدم كاملا مطلوب',
            'permission_roles_id.required' => 'دور صلاحية المستخدم مطلوب',
            'username.required' => 'اسم المستخدم للدخول به  مطلوب',
            'password.required' => ' كلمة المرور مطلوبة',
            'active.required' => '      حالة التفعيل مطلوبة',
            'email.required' => '        البريد الالكتروني مطلوب',

        ];
    }
}
