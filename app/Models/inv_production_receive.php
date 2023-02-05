<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class inv_production_receive extends Model
{
    use HasFactory;
    protected $table="inv_production_receive";
protected $fillable=[
'order_type', 'auto_serial', 'inv_production_order_auto_serial', 'order_date',
 'production_lines_code', 'is_approved', 'com_code', 'notes', 'discount_type', 
 'discount_percent', 'discount_value', 'tax_percent', 'total_cost_items', 'tax_value',
  'total_befor_discount', 'total_cost', 'account_number', 'money_for_account', 'pill_type',
   'what_paid', 'what_remain', 'treasuries_transactions_id', 'Supplier_balance_befor', 
   'Supplier_balance_after', 'added_by', 'created_at', 'updated_at', 'updated_by', 
   'store_id', 'approved_by'
];
}
