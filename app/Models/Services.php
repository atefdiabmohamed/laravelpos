<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    use HasFactory;
    protected $table="services";
    protected $fillable=[
        'name','type','created_at','updated_at','added_by','updated_by','com_code','date','active' 
        ];

}
