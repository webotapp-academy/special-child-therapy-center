<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('iep_goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->string('domain'); // Speech & Communication, Occupational & Sensory, Behavioral Regulation, Cognitive & Academic, Social & Play, Life Skills (ADL)
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('baseline')->nullable(); // Where child started
            $table->date('target_date')->nullable();
            $table->unsignedTinyInteger('progress_percentage')->default(0); // 0-100
            $table->string('status')->default('in_progress'); // not_started, in_progress, achieved, mastered, needs_revision
            $table->text('evaluator_notes')->nullable();
            $table->timestamps();
        });

        Schema::create('iep_milestones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('iep_goal_id')->constrained('iep_goals')->cascadeOnDelete();
            $table->string('milestone_title');
            $table->boolean('is_completed')->default(false);
            $table->date('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iep_milestones');
        Schema::dropIfExists('iep_goals');
    }
};
