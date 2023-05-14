<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admins_stores extends Model
{
    use HasFactory;
    protected $table="admins_stores";
    protected $fillable=[
        'admin_id','store_id','created_at','updated_at','added_by','updated_by','com_code','date','active' 
        ];
}
