<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'order_id',
        'transaction_state',
        'gross',
        'net',
        'fee',
        'refunded_amount',
        'pos_id',
        'currency_id',
        'merchant_id',
        'settlement_date',
    ];
}
