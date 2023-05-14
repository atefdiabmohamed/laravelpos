<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission_rols extends Model
{
    use HasFactory;

    protected $table="permission_roles";
    protected $fillable=[
        'name', 'created_at', 'added_by', 'updated_at', 'updated_by', 'com_code', 'date', 'active'     ];

}
