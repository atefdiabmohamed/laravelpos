<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminShiftsRequest extends FormRequest
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
         'treasuries_id'=>'required',
  
        ];
    }

    public function messages()
    {
        return [
        'treasuries_id.required'=>'كود الخزنة مطلوب',
         
        ];
    }
}
