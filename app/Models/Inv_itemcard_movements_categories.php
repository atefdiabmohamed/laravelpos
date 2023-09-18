<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inv_itemcard_movements_categories extends Model
{
    use HasFactory;

    protected $table="inv_itemcard_movements_categories";
    protected $fillable=[
        'id','name'     ];
}
