<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DelegatesRequestAdd extends FormRequest
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
            'name' => 'required',
            'active' => 'required',
            'start_balance_status' => 'required',
            'start_balance' => 'required|min:0',
            'percent_type' => 'required',
            'percent_salaes_commission_kataei' => 'required',

            'percent_salaes_commission_nosjomla' => 'required',
            'percent_salaes_commission_jomla' => 'required',
            'percent_collect_commission' => 'required',


        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'اسم المندوب مطلوب',
            'active.required' => '   حالة تفعيل الصنف مطلوب',
            'start_balance_status.required' => '   حالة الحساب اول المدة مطلوب',
            'start_balance.required' => '    رصيد اول المدة مطلوب',
            'percent_type.required' =>'نوع عمولة المندوب بالفواتير',
            'percent_salaes_commission_kataei.required' => '  عمولة المندوب بالمبيعات قطاعي  ',
            'percent_salaes_commission_nosjomla.required' => '  عمولة المندوب بمبيعات نص الجملة  ',
            'percent_salaes_commission_jomla.required' => '  عمولة المندوب بمبيعات الجملة ',
            'percent_collect_commission.required' => '  عمولة المندوب بتحصيل الآجل',




        ];
    }
}
