<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    protected $table = 'refunds';

    // Mass assignable attributes
    protected $fillable = [
        'transaction_id',
        'invoice_id',
        'transaction_state',
        'amount',
    ];

    // Use Eloquent timestamps
    public $timestamps = true;

    /**
     * Refund belongs to a Transaction
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
