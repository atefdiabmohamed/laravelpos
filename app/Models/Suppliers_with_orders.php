<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suppliers_with_orders extends Model
{
    protected $table="suppliers_with_orders";
    protected $fillable=[
        'order_type', 'auto_serial', 'DOC_NO', 'order_date', 'suuplier_code', 'is_approved', 'com_code',
         'notes', 'discount_type', 'discount_percent', 'discount_value', 'tax_percent', 'tax_value',
          'total_befor_discount', 'total_cost', 'account_number', 'money_for_account', 'pill_type',
           'what_paid', 'what_remain', 'treasuries_transactions_id', 'Supplier_balance_befor',
            'Supplier_balance_after', 'added_by', 'created_at', 'updated_at', 'updated_by','total_cost_items','store_id'
    ];
}
