<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyCareLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'log_date',
        'morning_mood',
        'afternoon_mood',
        'meal_intake',
        'meal_notes',
        'potty_training_log',
        'nap_minutes',
        'meltdown_count',
        'meltdown_triggers',
        'teacher_notes_for_parent',
        'logged_by_id',
    ];

    protected $casts = [
        'log_date' => 'date',
        'nap_minutes' => 'integer',
        'meltdown_count' => 'integer',
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

