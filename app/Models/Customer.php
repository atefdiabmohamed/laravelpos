<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table="customers";
    protected $fillable=[
        'name','account_number',
        'start_balance','current_balance','notes','customer_code','phones','address'
        ,'created_at','updated_at','added_by','updated_by','com_code','date','active','start_balance_status'
        ];
}
