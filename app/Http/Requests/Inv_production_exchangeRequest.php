<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Inv_production_exchangeRequest extends FormRequest
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
         'inv_production_order_auto_serial'=>'required',
         'production_lines_code'=>'required',
         'pill_type'=>'required',
         'order_date'=>'required',
         'store_id'=>'required'
        ];
    }

    public function messages()
    {
        return [
        'inv_production_order_auto_serial.required'=>'كود أمر التشغيل مطلوب  ',
        'pill_type.required'=>'نوع الفاتورة مطلوب',
        'order_date.required'=>'تاريخ الفاتورة مطلوب',
        'store_id.required'=>'    مخزن صرف الخامات مطلوب',
        'production_lines_code.required'=>'      خط الانتاج مطلوب',

        ];
    }
}
