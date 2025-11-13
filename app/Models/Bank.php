<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $table = 'banks';

    protected $fillable = [
        'name',
        'issuer_name',
        'api_url',
        'user_name',
        'user_password',
        'status',
        'code',
        'branch'
    ];

    // Status constants
    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;

    // Optional helper method for Blade
    public static function statusOptions(): array
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_INACTIVE => 'Inactive',
        ];
    }
}
