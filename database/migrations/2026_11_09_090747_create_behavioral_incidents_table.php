<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('behavioral_incidents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->date('incident_date');
            $table->time('incident_time');
            $table->string('location')->default('Classroom'); // Classroom, Playground, Sensory Room, Cafeteria, Transit Bus
            $table->text('antecedent'); // What happened right before: loud sound, task demand, transition
            $table->string('behavior_type'); // Meltdown, Aggression, Self-injurious, Running away/elopement, Screaming, Tantrum
            $table->text('behavior_description')->nullable();
            $table->string('intensity')->default('Moderate'); // Mild, Moderate, Severe
            $table->unsignedSmallInteger('duration_minutes')->default(5);
            $table->text('intervention_used'); // Deep pressure, calming room, weighted vest, redirection
            $table->text('post_incident_state')->nullable(); // Settled, Tired, Happy, Needing rest
            $table->foreignId('logged_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('notified_parent')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('behavioral_incidents');
    }
};
