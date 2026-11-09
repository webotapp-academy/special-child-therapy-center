<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IepMilestone extends Model
{
    use HasFactory;

    protected $fillable = [
        'iep_goal_id',
        'milestone_title',
        'is_completed',
        'completed_at',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'completed_at' => 'date',
    ];

    public function iepGoal()
    {
        return $this->belongsTo(IepGoal::class);
    }
}

