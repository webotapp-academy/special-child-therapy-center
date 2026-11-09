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
        Schema::create('daily_care_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->date('log_date');
            $table->string('morning_mood')->default('Happy'); // Happy, Calm, Anxious, Agitated, Tired
            $table->string('afternoon_mood')->default('Calm');
            $table->string('meal_intake')->default('Full Meal'); // Full Meal, Half Eaten, Picky / Textures Refused, Fed with Support
            $table->string('meal_notes')->nullable();
            $table->string('potty_training_log')->default('Routine Success'); // Routine Success, 1 Accident, Prompted Success, Diaper
            $table->unsignedSmallInteger('nap_minutes')->default(0);
            $table->unsignedTinyInteger('meltdown_count')->default(0);
            $table->string('meltdown_triggers')->nullable();
            $table->text('teacher_notes_for_parent')->nullable();
            $table->foreignId('logged_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_care_logs');
    }
};
