<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $fillable = [
        'name',
        'issuer_name',
        'api_url',
        'user_name',
        'user_password',
        'status',
        'code',
        'branch',
        'created_at',
        'updated_at'
    ];
}
