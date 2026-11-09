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
        Schema::create('therapy_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('therapist_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('therapist_name')->nullable();
            $table->string('therapy_type'); // Speech Therapy, Occupational Therapy, ABA Therapy, Sensory Integration, Physiotherapy
            $table->date('session_date');
            $table->unsignedSmallInteger('duration_minutes')->default(45);
            $table->text('activities_performed')->nullable();
            $table->string('engagement_level')->default('Good'); // Excellent, Good, Distracted, Sensory Overload, Resistant
            $table->text('clinical_soap_notes')->nullable(); // Subjective, Objective, Assessment, Plan
            $table->text('parent_summary')->nullable(); // Message specifically highlighted for the parent portal
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('therapy_sessions');
    }
};
