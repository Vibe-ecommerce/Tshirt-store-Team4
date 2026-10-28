<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = [
        'code',
        'description',
        'discount_percent',
        'min_spend',
        'status',
        'uses_count',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'discount_percent' => 'integer',
        'min_spend' => 'float',
    ];
}
