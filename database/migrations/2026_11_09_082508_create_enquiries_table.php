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
        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('enquiry_no')->unique();
            $table->string('child_name');
            $table->date('dob')->nullable();
            $table->string('gender')->nullable(); // Male, Female, Other
            $table->string('parent_name');
            $table->string('relation')->default('Parent'); // Father, Mother, Guardian
            $table->string('phone');
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('referred_by')->nullable();
            $table->json('primary_concerns')->nullable();
            $table->text('notes')->nullable();
            $table->string('status')->default('new'); // new, assessment_scheduled, assessed, admitted, cancelled
            $table->dateTime('assessment_scheduled_at')->nullable();
            $table->foreignId('handled_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enquiries');
    }
};
