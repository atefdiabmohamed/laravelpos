<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Services_orders_request extends FormRequest
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
         'order_date'=>'required',
         'pill_type'=>'required',
         'order_type'=>'required',
         'is_account_number'=>'required',
         'account_number'=>'required_if:is_account_number,1',
         'entity_name'=>'required_if:is_account_number,0',
        ];
    }

    public function messages()
    {
        return [
        'order_date.required'=>'  تاريخ الفاتورة مطلوب',
        'pill_type.required'=>'نوع الفاتورة مطلوب',
        'order_type.required'=>'فئة الفاتورة مطلوب',
        'is_account_number.required'=>'  هل حساب مالي مطلوب',
        'account_number.required_if'=>'    رقم الحساب المالي مطلوب',
        'entity_name.required_if'=>'     اسم الجهة  مطلوب',
        ];
    }
}
