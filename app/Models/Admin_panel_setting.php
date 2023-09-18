<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin_panel_setting extends Model
{
    use HasFactory;
    protected $table="admin_panel_settings";
    protected $fillable=[
        'system_name','photo','active','general_alert','address',
        'phone','created_at','updated_at','added_by','updated_by',
        'com_code' ,'customer_parent_account_number',
        'suppliers_parent_account_number','delegate_parent_account_number',
        'employees_parent_account_number','production_lines_parent_account',
        'is_set_Batches_setting','Batches_setting_type','default_unit'
        ];
}
