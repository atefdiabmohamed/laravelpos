<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales_invoices_details extends Model
{
    use HasFactory;
    protected $table="sales_invoices_details";
    protected $fillable=[
        'sales_invoices_auto_serial', 'com_code', 'quantity',
         'uom_id', 'isparentuom', 'unit_price', 'total_price',
          'invoice_date', 'added_by', 'created_at', 'updated_by',
           'updated_at', 'item_code', 'sales_item_type', 'batch_auto_serial',
            'production_date', 'expire_date',
            'is_normal_orOther','store_id','date','sales_invoices_id','itemCostPriceFromBatch','taoalitemCostPriceFromBatch','item_total_earnings'
    ];
    }

