<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemcardRequestUpdate extends FormRequest
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
         'name'=>'required',
         'inv_itemcard_categories_id'=>'required',
         'price'=>'required',
         'nos_gomla_price'=>'required',
         'gomla_price'=>'required',
         'cost_price'=>'required',
         'price_retail'=>'required_if:does_has_retailunit,1',
         'nos_gomla_price_retail'=>'required_if:does_has_retailunit,1',
         'gomla_price_retail'=>'required_if:does_has_retailunit,1',
         'cost_price_retail'=>'required_if:does_has_retailunit,1',
         'has_fixced_price'=>'required',
         'active'=>'required',

        ];
    }

    public function messages()
    {
        return [
        'name.required'=>'اسم الصنف مطلوب',
        'inv_itemcard_categories_id.required'=>'فئة الصنف مطلوب',
        'price.required'=>'  سعر القطاعي للوحدة الاب مطلوب',
        'nos_gomla_price.required'=>'  سعر النص جملة لوحدة الاب مطلوب',
        'gomla_price.required'=>'سعر الجملة لوحده الاب مطلوب  ',
        'cost_price.required'=>'  تكلفة الشراء لوحدة الاب مطلوب',
        'price_retail.required_if'=>'     سعر القطاعي لوحده التجزئة مطلوب ',
        'nos_gomla_price_retail.required_if'=>'     سعر النص جملة لوحده التجزئة مطلوب ',
        'gomla_price_retail.required_if'=>'     سعر الجملة لوحده التجزئة مطلوب ',
        'cost_price_retail.required_if'=>'     سعر الشراء لوحده التجزئة مطلوب ',
        'has_fixced_price.required'=>'   هل للنصف سعر ثابت مطلوب',
        'active.required'=>'   حالة تفعيل الصنف مطلوب',

        ];
    }
    
}
