<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class inv_production_receive_details extends Model
{
    use HasFactory;
    protected $table="inv_production_receive_details";
    protected $fillable=[
    'inv_production_receive_id', 'inv_production_receive_auto_serial', 'order_type',
     'com_code', 'deliverd_quantity', 'uom_id', 'isparentuom', 'unit_price', 'total_price',
      'order_date', 'added_by', 'created_at', 'updated_by', 'updated_at', 'item_code', 
      'batch_auto_serial', 'production_date', 'expire_date', 'item_card_type'
];

}
