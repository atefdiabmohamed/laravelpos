<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account_types extends Model
{
    use HasFactory;

    protected $table="account_types";
    protected $fillable=[
        'name','active','relatediternalaccounts'
        ];
}
