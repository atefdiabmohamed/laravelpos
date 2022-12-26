<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Inv_production_order extends Model
{
use HasFactory;
protected $table="inv_production_order";
protected $fillable=[
'auto_serial', 'production_plane', 'is_approved', 
'added_by', 'updated_by', 'created_at', 'updated_at',
'com_code', 'approved_by', 'approved_at', 'is_closed',
'closed_by', 'closed_at','date','production_plan_date'
];
}