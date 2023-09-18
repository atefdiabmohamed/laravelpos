<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class inv_stores_transfer extends Model
{
    use HasFactory;
    protected $table="inv_stores_transfer";
    protected $fillable=[
        'auto_serial', 'transfer_from_store_id', 'transfer_to_store_id', 
        'order_date', 'is_approved', 'com_code', 'notes', 
        'total_cost_items', 'added_by','inv_stores_transfer',
         'created_at', 'updated_at', 'updated_by', 'approved_by','approved_at'
        ];
}
