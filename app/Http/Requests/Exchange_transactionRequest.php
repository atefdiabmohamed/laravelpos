<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Exchange_transactionRequest extends FormRequest
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
         'move_date'=>'required',
         'mov_type'=>'required',
         'account_number'=>'required',
         'treasuries_id'=>'required',
         'money'=>'required',
         'byan'=>'required',



        ];
    }

    public function messages()
    {
        return [
        'move_date.required'=>' تاريخ الحركة مطلوب',
        'mov_type.required'=>' نوع الحركة  مطلوب',
        'account_number.required'=>' الحساب المالي  مطلوب',
        'treasuries_id.required'=>'كود خزنة التحصيل مطلوب',
        'money.required'=>' قيمة مبلغ المصروف مطلوب',
        'byan.required'=>'   البيان مطلوب',

        ];
    }
}
