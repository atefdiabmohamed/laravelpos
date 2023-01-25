<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inv_stores_inventory_details extends Model
{
    use HasFactory;
    protected $table="inv_stores_inventory_details";
    protected $fillable=[
        'inv_stores_inventory_auto_serial', 'item_code', 
        'inv_uoms_id', 'batch_auto_serial', 'old_quantity', 
        'new_quantity', 'diffrent_quantity', 'notes', 'is_closed',
         'added_by', 'created_at', 'updated_by', 'updated_at',
          'cloased_by', 'closed_at', 'com_code','unit_cost_price','total_cost_price'
          ,'production_date','expired_date','inv_stores_inventory_id'

    ];
}
