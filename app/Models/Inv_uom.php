<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inv_uom extends Model
{
    use HasFactory;
    protected $table="inv_uoms";
    protected $fillable=[
        'name','is_master','created_at','updated_at','added_by','updated_by','com_code','date','active' 
        ];
}
