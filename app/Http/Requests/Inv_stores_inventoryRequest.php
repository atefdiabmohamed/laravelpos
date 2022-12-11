<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Inv_stores_inventoryRequest extends FormRequest
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
         'inventory_date'=>'required',
         'inventory_type'=>'required',
         'store_id'=>'required',

        ];
    }

    public function messages()
    {
        return [
        'inventory_date.required'=>' تاريخ امر الجرد  مطلوب',
        'inventory_type.required'=>'نوع امر الجرد مطلوب',
        'store_id.required'=>'  مخزن الجرد  مطلوب',
        ];
    }
}
