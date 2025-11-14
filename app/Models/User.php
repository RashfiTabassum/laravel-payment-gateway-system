<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const TYPE_ADMIN = 1;
    const TYPE_MERCHANT = 2;


    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type', // admin or merchant
        'status',    // active/inactive (1 or 0)
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'status' => 'boolean',
    ];

    /**
     * Automatically hash password when setting it.
     */
    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    /**
     * Get the merchant profile associated with the user.
     */
    public function merchant()
    {
        return $this->hasOne(Merchant::class, 'user_id', 'id');
    }
    // Optional helper methods
    public function isAdmin()
    {
        return $this->user_type == self::TYPE_ADMIN;
    }

    public function isMerchant()
    {
        return $this->user_type == self::TYPE_MERCHANT;
    }


}
