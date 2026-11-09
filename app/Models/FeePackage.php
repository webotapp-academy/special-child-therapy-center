<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeePackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'amount',
        'billing_cycle',
        'sessions_count',
        'is_active',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'sessions_count' => 'integer',
        'is_active' => 'boolean',
    ];

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}

