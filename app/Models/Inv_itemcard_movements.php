<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inv_itemcard_movements extends Model
{
    use HasFactory;
    protected $table="inv_itemcard_movements";
    public $timestamps=false;
    protected $fillable=[
        'inv_itemcard_movements_categories', 'item_code', 'items_movements_types', 
        'FK_table', 'FK_table_details', 'byan', 'quantity_befor_movement', 
        'quantity_after_move', 'added_by', 'date', 'created_at', 'com_code' ,'store_id',
        'quantity_befor_move_store','quantity_after_move_store'
        ];
}
