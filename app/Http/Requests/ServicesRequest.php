<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServicesRequest extends FormRequest
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
         'type'=>'required',
        ];
    }

    public function messages()
    {
        return [
        'name.required'=>'اسم الخدمة مطلوب',
        'active.required'=>'حالة تفعيل الخدمة مطلوب',
        'type.required'=>' نوع الخدمة  مطلوب',
        ];
    }
}
