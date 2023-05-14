<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mov_type extends Model
{
    use HasFactory;
    protected $table="mov_type";
    protected $fillable=[
        'name', 'active', 'in_screen', 'is_private_internal'      ];

    }
