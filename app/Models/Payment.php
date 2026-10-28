<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'transaction_id',
        'amount',
        'payment_method',
        'payment_slip',
        'payment_reference',
        'status',
        'refund_reason',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
