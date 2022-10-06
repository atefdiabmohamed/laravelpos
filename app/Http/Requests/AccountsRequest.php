<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountsRequest extends FormRequest
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
            'is_parent' => 'required',
            'account_type' => 'required',
            'parent_account_number' => 'required_if:is_parent,0',
            'start_balance_status' => 'required',
            'start_balance' => 'required|min:0',
            'active' => 'required',

        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'اسم الحساب مطلوب',
            'account_type.required' => 'نوع الحساب مطلوب',
            'is_parent.required' => ' هل الحساب اب مطلوب',
            'parent_account_number.required_if' => '  الحساب الاب مطلوب',
            'start_balance_status.required' => '   حالة الحساب اول المدة مطلوب',
            'start_balance.required' => '    رصيد اول المدة مطلوب',
            'is_archived.required' => '   حالة تفعيل الصنف مطلوب',


        ];
    }
}
