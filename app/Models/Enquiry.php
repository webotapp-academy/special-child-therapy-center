<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'enquiry_no',
        'child_name',
        'dob',
        'gender',
        'parent_name',
        'relation',
        'phone',
        'email',
        'address',
        'referred_by',
        'primary_concerns',
        'notes',
        'status',
        'assessment_scheduled_at',
        'handled_by',
    ];

    protected $casts = [
        'dob' => 'date',
        'assessment_scheduled_at' => 'datetime',
        'primary_concerns' => 'array',
    ];

    public function handler()
    {
        return $this->belongsTo(User::class, 'handled_by');
    }

    public function diagnosticAssessment()
    {
        return $this->hasOne(DiagnosticAssessment::class);
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }
}

