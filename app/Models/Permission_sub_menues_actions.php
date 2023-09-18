<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission_sub_menues_actions extends Model
{
    use HasFactory;
    protected $table="permission_sub_menues_actions";
    protected $fillable=[
        'name', 'created_at', 'added_by', 'updated_at', 'updated_by', 'com_code', 'date', 'active' ,'permission_sub_menues_id'    ];

}
