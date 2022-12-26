<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class inv_production_orderRequest extends FormRequest
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
            'production_plan_date'=>'required',
            'production_plane'=>'required'
        ];
    }

    public function messages()
    {
        return [
            'production_plan_date.required'=>'  تاريخ خطة أمر التشغيل مطلوب',
            'production_plane.required'=>'  تفاصيل خطة أمر التشغيل مطلوبة'
 
        ];
    }
}
