<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_no',
        'student_id',
        'fee_package_id',
        'item_description',
        'amount',
        'invoice_date',
        'due_date',
        'paid_date',
        'payment_method',
        'transaction_reference',
        'status',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'invoice_date' => 'date',
        'due_date' => 'date',
        'paid_date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function feePackage()
    {
        return $this->belongsTo(FeePackage::class);
    }
}

