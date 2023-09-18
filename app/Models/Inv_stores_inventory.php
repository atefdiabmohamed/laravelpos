<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inv_stores_inventory extends Model
{
    use HasFactory;
    protected $table="inv_stores_inventory";
    protected $fillable=[
        'auto_serial', 'inventory_date', 'is_closed',
         'total_cost_batches', 'notes', 'added_by', 
         'created_at', 'updated_by', 'updated_at', 'com_code',
         'inventory_type','store_id','date','cloased_by',
         'closed_at'
        ];
}
