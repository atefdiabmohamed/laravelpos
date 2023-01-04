<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inv_production_lines extends Model
{
    use HasFactory;
    protected $table="inv_production_lines";
    protected $fillable=[
        'production_lines_code', 'name', 'account_number', 'start_balance_status', 
        'start_balance', 'current_balance', 'notes', 'added_by', 'updated_by', 'created_at',
         'updated_at', 'active', 'com_code', 'date', 'address', 'phones'        ];

}
