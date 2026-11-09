<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiagnosticAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'assessment_no',
        'enquiry_id',
        'child_name',
        'dob',
        'gender',
        'assessment_date',
        'assessor_id',
        'assessor_name',
        'cars_score',
        'cars_severity',
        'isaa_score',
        'primary_diagnosis',
        'severity_level',
        'speech_evaluation',
        'motor_evaluation',
        'sensory_profile',
        'behavioral_observations',
        'recommendation',
        'status',
    ];

    protected $casts = [
        'dob' => 'date',
        'assessment_date' => 'date',
        'cars_score' => 'decimal:1',
        'isaa_score' => 'decimal:1',
        'sensory_profile' => 'array',
    ];

    public function enquiry()
    {
        return $this->belongsTo(Enquiry::class);
    }

    public function assessor()
    {
        return $this->belongsTo(User::class, 'assessor_id');
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }
}

