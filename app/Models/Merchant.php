<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
 
class Merchant extends Authenticatable
{
    use Notifiable;
 
    // Use the existing users table
    protected $table = 'merchants';
 
    protected $fillable = [
        'name', 'email', 'password', 'user_type', 'status',
    ];
 
    protected $hidden = ['password', 'remember_token'];
 
    protected $casts = [
        'status' => 'boolean',
        'email_verified_at' => 'datetime',
    ];
 
    /**
     * Only rows with user_type = 2 are "merchants”.
     * Also force user_type=2 (and default status) when creating.
     */
    protected static function booted(): void
    {
        // static::addGlobalScope('adminsOnly', function (Builder $q) {
        //     $q->where('user_type', 2);
        // });
 
        static::creating(function (self $merchant) {
            $merchant->user_type = 2;
            // Set a default status if your column exists and isn’t set
            if (is_null($merchant->status)) {
                $merchant->status = 2;
            }
        });
    }
 
    /**
     * Auto-hash password when set (skips if already hashed).
     */
    public function setPasswordAttribute($value): void
    {
        if (!$value) return;
        $this->attributes['password'] = str_starts_with($value, '$2y$')
            ? $value
            : Hash::make($value);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}