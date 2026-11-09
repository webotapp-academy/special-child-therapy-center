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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('admission_no')->unique();
            $table->foreignId('enquiry_id')->nullable()->constrained('enquiries')->nullOnDelete();
            $table->foreignId('diagnostic_assessment_id')->nullable()->constrained('diagnostic_assessments')->nullOnDelete();
            $table->foreignId('parent_user_id')->nullable()->constrained('users')->nullOnDelete();
            
            // Basic Child Info
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->date('dob');
            $table->string('gender'); // Male, Female, Other
            $table->string('blood_group')->nullable();
            $table->string('photo')->nullable();
            $table->date('admission_date');
            $table->string('classroom_batch')->default('Early Intervention Batch');
            $table->foreignId('primary_educator_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('shadow_teacher')->nullable();
            
            // Diagnosis & Clinical
            $table->string('primary_diagnosis'); // Autism Spectrum Disorder, ADHD, GDD, Cerebral Palsy, Down Syndrome
            $table->string('severity_level')->nullable(); // Level 1, Level 2, Level 3
            
            // Autism & Sensory Needs Profile
            $table->string('communication_mode')->default('Verbal'); // Verbal, Non-Verbal, PECS, AAC Device, Sign
            $table->text('sensory_triggers')->nullable(); // Loud sound, crowded room, fluorescent lights, sudden touch
            $table->text('calming_methods')->nullable(); // Deep pressure, weighted vest, quiet corner, swinging, headphones
            $table->string('comfort_item')->nullable(); // Soft blanket, stress ball, chew tube, plush toy
            $table->text('food_texture_preferences')->nullable(); // Crunchy, pureed, avoids mixed textures
            $table->text('allergies')->nullable();
            $table->text('medical_notes')->nullable(); // Seizures, medications
            
            // Guardian Info
            $table->string('guardian_name');
            $table->string('guardian_relation')->default('Mother'); // Mother, Father, Guardian
            $table->string('guardian_phone');
            $table->string('guardian_email')->nullable();
            $table->text('address')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            
            $table->string('status')->default('active'); // active, inactive, graduated
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
