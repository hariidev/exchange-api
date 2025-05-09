<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ExchangeRate extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'date',
        'base_currency',
        'target_currency',
        'rate'
    ];

    protected $casts = [
        'date' => 'date:Y-m-d',
        'rate' => 'decimal:4'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['rate', 'date'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
