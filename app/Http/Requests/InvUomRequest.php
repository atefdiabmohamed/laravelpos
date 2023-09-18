<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvUomRequest extends FormRequest
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
         'active'=>'required',
         'is_master'=>'required',

        ];
    }

    public function messages()
    {
        return [
        'name.required'=>'اسم الوحدة مطلوب',
        'active.required'=>'حالة تفعيل الوحدة مطلوب',
        'is_master.required'=>' نوع الوحدة  مطلوب',
        ];
    }
}
