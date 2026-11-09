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
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('staff')->after('email'); // admin, educator, therapist, caregiver, parent
            $table->string('phone')->nullable()->after('role');
            $table->string('specialization')->nullable()->after('phone'); // Speech Therapist, OT, Special Educator, Child Psychologist
            $table->boolean('is_active')->default(true)->after('specialization');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'phone', 'specialization', 'is_active']);
        });
    }
};
