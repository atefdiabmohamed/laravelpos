<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesReturn extends Model
{
    use HasFactory;
    protected $table="sales_invoices_return";
    protected $fillable=[
        'sales_matrial_types', 'auto_serial','return_type', 'invoice_date', 'customer_code', 
        'is_approved', 'com_code', 'notes', 'discount_type', 'discount_percent',
         'discount_value', 'tax_percent', 'total_cost_items', 'tax_value', 'total_befor_discount',
          'total_cost', 'account_number', 'money_for_account', 'pill_type', 'what_paid', 'what_remain',
           'treasuries_transactions_id', 'customer_balance_befor', 'customer_balance_after', 'added_by',
            'created_at', 'updated_at', 'updated_by', 'approved_by','is_has_customer','delegate_code','date'      ];

}
