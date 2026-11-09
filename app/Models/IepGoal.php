<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IepGoal extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'domain',
        'title',
        'description',
        'baseline',
        'target_date',
        'progress_percentage',
        'status',
        'evaluator_notes',
    ];

    protected $casts = [
        'target_date' => 'date',
        'progress_percentage' => 'integer',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function milestones()
    {
        return $this->hasMany(IepMilestone::class);
    }
}

