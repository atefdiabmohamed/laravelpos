<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treasuries_transactions extends Model
{
    use HasFactory;
    protected $table="treasuries_transactions";
    protected $fillable=[
        'treasuries_id', 'money', 'mov_type', 'the_foregin_key', 'date', 'last_update', 'added_by', 'updated_by', 'com_code', 'ac_yearly_trn_ENTRY_NO', 'account_number', 'is_account',
         'CLOSE_FLAG', 'closed_by', 'byan', 'users_shiftes_id', 'money_for_account', 'the_date_time', 'treasuries_idReview', 'userShiftReview', 'delegates_code', 'sales_material_type', 'delegate_commission', 'delegate_commission_value', 'account_balance_after',
         'move_section',"move_date","shift_code","isal_number","is_approved","auto_serial"
    ];
}
