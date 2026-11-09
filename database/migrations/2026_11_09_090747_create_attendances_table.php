<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->date('date');
            $table->string('status')->default('present'); // present, absent, late, sensory_recovery_day
            $table->time('arrival_time')->nullable();
            $table->string('arrival_state')->default('Calm'); // Calm, Anxious, Agitated, Overstimulated, Sleepy
            $table->string('transport_mode')->default('School Bus'); // School Bus, Parent Drop, Walk, Shadow Aide
            $table->string('bus_route')->nullable();
            $table->string('transit_attendant')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['student_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
