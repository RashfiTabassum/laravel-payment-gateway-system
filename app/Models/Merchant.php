<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    protected $table = 'merchants';

    protected $fillable = [
        'user_id',
        'store_id',
        'name',
        'email',
        'address',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * A merchant belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
