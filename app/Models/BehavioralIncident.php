<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BehavioralIncident extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'incident_date',
        'incident_time',
        'location',
        'antecedent',
        'behavior_type',
        'behavior_description',
        'intensity',
        'duration_minutes',
        'intervention_used',
        'post_incident_state',
        'logged_by_id',
        'notified_parent',
    ];

    protected $casts = [
        'incident_date' => 'date',
        'duration_minutes' => 'integer',
        'notified_parent' => 'boolean',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function loggedBy()
    {
        return $this->belongsTo(User::class, 'logged_by_id');
    }
}

