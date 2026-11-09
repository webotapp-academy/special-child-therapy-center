<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'admission_no',
        'enquiry_id',
        'diagnostic_assessment_id',
        'parent_user_id',
        'first_name',
        'last_name',
        'dob',
        'gender',
        'blood_group',
        'photo',
        'admission_date',
        'classroom_batch',
        'primary_educator_id',
        'shadow_teacher',
        'primary_diagnosis',
        'severity_level',
        'communication_mode',
        'sensory_triggers',
        'calming_methods',
        'comfort_item',
        'food_texture_preferences',
        'allergies',
        'medical_notes',
        'guardian_name',
        'guardian_relation',
        'guardian_phone',
        'guardian_email',
        'address',
        'emergency_contact_phone',
        'status',
    ];

    protected $casts = [
        'dob' => 'date',
        'admission_date' => 'date',
    ];

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function getAgeAttribute(): int
    {
        return $this->dob ? Carbon::parse($this->dob)->age : 0;
    }

    public function enquiry()
    {
        return $this->belongsTo(Enquiry::class);
    }

    public function diagnosticAssessment()
    {
        return $this->belongsTo(DiagnosticAssessment::class);
    }

    public function parentUser()
    {
        return $this->belongsTo(User::class, 'parent_user_id');
    }

    public function educator()
    {
        return $this->belongsTo(User::class, 'primary_educator_id');
    }

    public function iepGoals()
    {
        return $this->hasMany(IepGoal::class);
    }

    public function therapySessions()
    {
        return $this->hasMany(TherapySession::class)->latest('session_date');
    }

    public function dailyCareLogs()
    {
        return $this->hasMany(DailyCareLog::class)->latest('log_date');
    }
}

