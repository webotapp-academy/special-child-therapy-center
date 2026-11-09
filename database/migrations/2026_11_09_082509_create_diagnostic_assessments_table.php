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
        Schema::create('diagnostic_assessments', function (Blueprint $table) {
            $table->id();
            $table->string('assessment_no')->unique();
            $table->foreignId('enquiry_id')->nullable()->constrained('enquiries')->nullOnDelete();
            $table->string('child_name');
            $table->date('dob')->nullable();
            $table->string('gender')->nullable();
            $table->date('assessment_date');
            $table->foreignId('assessor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('assessor_name')->nullable();
            
            // Clinical & Diagnostic metrics
            $table->decimal('cars_score', 4, 1)->nullable(); // 15 to 60
            $table->string('cars_severity')->nullable(); // Non-Autistic, Mild-Moderate, Severe
            $table->decimal('isaa_score', 5, 1)->nullable(); // ISAA score
            $table->string('primary_diagnosis'); // Autism Spectrum Disorder (ASD), ADHD, GDD, etc.
            $table->string('severity_level')->nullable(); // Level 1 (Requiring Support), Level 2 (Substantial Support), Level 3 (Very Substantial Support)
            
            // Domain evaluations
            $table->text('speech_evaluation')->nullable(); // Receptive/Expressive language, non-verbal, echolalia
            $table->text('motor_evaluation')->nullable(); // Fine/Gross motor, vestibular, balance
            $table->json('sensory_profile')->nullable(); // Auditory, Visual, Tactile, Oral, Proprioceptive details
            $table->text('behavioral_observations')->nullable(); // Stimming, eye contact, emotional regulation, attention span
            
            // Recommendations
            $table->text('recommendation')->nullable(); // Day schooling, OT/Speech dosage, shadow teacher
            $table->string('status')->default('completed'); // draft, completed, admitted
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diagnostic_assessments');
    }
};
