<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Admin_panel_settings_Request extends FormRequest
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
            'system_name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'customer_parent_account_number' => 'required',
            'suppliers_parent_account_number' => 'required',
            'delegate_parent_account_number' => 'required',
            'employees_parent_account_number' => 'required',
            'production_lines_parent_account' => 'required',
            'Batches_setting_type' => 'required|sometimes',

            


        ];
    }

    public function messages()
    {
        return [
            'system_name.required' => 'اسم الشركة مطلوب',
            'address.required' => 'عنوان الشركة مطلوب',
            'phone.required' => 'هاتف الشركة مطلوب',
            'customer_parent_account_number.required' => ' رقم الحساب المالي للعملاء الاب مطلوب',
            'suppliers_parent_account_number.required' => ' رقم الحساب المالي للموردين الاب مطلوب',
            'delegate_parent_account_number.required' => ' رقم الحساب المالي للمناديب الاب مطلوب',
            'employees_parent_account_number.required' => ' رقم الحساب المالي للموظفين الاب مطلوب',
            'production_lines_parent_account.required' => ' رقم الحساب المالي لخطوط الانتاج الاب مطلوب'

        ];
    }
}
