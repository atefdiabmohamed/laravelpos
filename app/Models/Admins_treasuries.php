<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admins_treasuries extends Model
{
    use HasFactory;
    protected $table="admins_treasuries";
    protected $fillable=[
        'admin_id','treasuries_id','created_at','updated_at','added_by','updated_by','com_code','date','active' 
        ];
}
