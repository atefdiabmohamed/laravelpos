<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class permission_sub_menuesequest extends FormRequest
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
         'permission_main_menues_id'=>'required',
         'active'=>'required',
        ];
    }

    public function messages()
    {
        return [
        'name.required'=>'اسم الدور مطلوب',
        'permission_main_menues_id.required'=>'اسم القائمة الرئيسية لها مطلوب',
        'active.required'=>'حالة تفعيل الدور مطلوب',

        ];
    }
}
