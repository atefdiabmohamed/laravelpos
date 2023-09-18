<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class services_with_orders extends Model
{
    use HasFactory;
    protected $table="services_with_orders";
    protected $fillable=[
        'order_type', 'auto_serial', 'order_date', 'is_approved', 'com_code', 'notes', 'discount_type', 
        'discount_percent', 'discount_value', 'tax_percent',
         'tax_value', 'total_befor_discount', 'total_cost', 
         'account_number', 'money_for_account', 'pill_type',
          'what_paid', 'what_remain', 'treasuries_transactions_id',
           'added_by', 'created_at', 'updated_at', 'updated_by',
            'approved_by','is_account_number','entity_name','total_services'
        ];

}
