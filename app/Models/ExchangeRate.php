<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExchangeRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'currency',
        'base_currency',
        'rate'
    ];

    protected $casts = [
        'date' => 'date:Y-m-d',
        'rate' => 'decimal:4'
    ];
}
