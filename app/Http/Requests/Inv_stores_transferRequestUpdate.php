<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Inv_stores_transferRequestUpdate extends FormRequest
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
         'transfer_from_store_id'=>'sometimes|required',
         'transfer_to_store_id'=>'sometimes|required'
       
        ];
    }

    public function messages()
    {
        return [

        'order_date.required'=>'تاريخ الفاتورة مطلوب',
        'transfer_from_store_id.required'=>'    مخزن الصرف ',
        'transfer_to_store_id.required'=>'    مخزن الاستلام',

        ];
    }
}
