<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pos extends Model
{
    protected $table = 'pos';

    protected $fillable = [
        'name',
        'bank_id',
        'currency_id',
        'status',
        'commission_percentage',
        'commission_fixed',
        'bank_fee',
        'settlement_day',
    ];

    protected $casts = [
        'status' => 'integer',
        'commission_percentage' => 'decimal:2',
        'commission_fixed'      => 'decimal:2',
        'bank_fee'              => 'decimal:2',
        'settlement_day'        => 'integer',
    ];

    // Relations
    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function currency()
    {
        return $this->belongsTo(\App\Models\Currency::class);
    }
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }


}
