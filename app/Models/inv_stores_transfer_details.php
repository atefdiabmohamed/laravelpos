<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class inv_stores_transfer_details extends Model
{
    use HasFactory;
    protected $table="inv_stores_transfer_details";
    protected $fillable=[
        'inv_stores_transfer_id', 'inv_stores_transfer_auto_serial', 
        'com_code', 'deliverd_quantity', 'uom_id', 'isparentuom', 'unit_price',
         'total_price', 'order_date', 'added_by', 'created_at', 'updated_by', 
         'updated_at', 'item_code', 'production_date', 'expire_date',
          'item_card_type','is_approved','approved_by','approved_at',
        'transfer_from_batch_id', 'transfer_to_batch_id','is_canceld_receive',
        'canceld_by','canceld_at','canceld_cause'
        ];
}
 