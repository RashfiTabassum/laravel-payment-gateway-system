<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Admin extends Authenticatable
{
    use Notifiable;

    public const USER_TYPE_ADMIN = 1;
    public const USER_TYPE_MERCHANT = 2;

    /** 
     * Status constants 
     */
    public const STATUS_ACTIVE = 1;
    public const STATUS_PASSIVE = 0;
    // Use the existing users table
    protected $table = 'users';

    protected $fillable = [
        'name', 'email', 'password', 'user_type', 'status',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'status' => 'boolean',
        'email_verified_at' => 'datetime',
    ];

    /**
     * Only rows with user_type = 1 are “admins”.
     * Also force user_type=1 (and default status) when creating.
     */
    protected static function booted(): void
    {
        static::addGlobalScope('adminsOnly', function (Builder $q) {
            $q->where('user_type', self::USER_TYPE_ADMIN);
        });

        static::creating(function (self $admin) {
            $admin->user_type = self::USER_TYPE_ADMIN;
            if (is_null($admin->status)) {
                $admin->status = self::STATUS_ACTIVE;
            }
        });
    }

    /**
     * Auto-hash password when set (skips if already hashed).
     */
    
    /**
     * @param string $value
     */
public function setPasswordAttribute($value): void
    {
        if (!$value) return;
        $this->attributes['password'] = str_starts_with($value, '$2y$')
            ? $value
            : Hash::make($value);
    }
}
