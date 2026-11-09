<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TherapySession extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'therapist_id',
        'therapist_name',
        'therapy_type',
        'session_date',
        'duration_minutes',
        'activities_performed',
        'engagement_level',
        'clinical_soap_notes',
        'parent_summary',
    ];

    protected $casts = [
        'session_date' => 'date',
        'duration_minutes' => 'integer',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function therapist()
    {
        return $this->belongsTo(User::class, 'therapist_id');
    }
}

