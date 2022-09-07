<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class inv_itemcard_categorie extends Model
{
    use HasFactory;
    protected $table="inv_itemcard_categories";
    protected $fillable=[
        'name','created_at','updated_at','added_by','updated_by','com_code','date','active' 
        ];
}
