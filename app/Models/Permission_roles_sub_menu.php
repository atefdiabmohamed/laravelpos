<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission_roles_sub_menu extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table="permission_roles_sub_menu";
    protected $fillable=[
        'permission_roles_main_menus_id', 'permission_sub_menues_id', 'added_by', 'created_at','permission_roles_id'      ];

}
