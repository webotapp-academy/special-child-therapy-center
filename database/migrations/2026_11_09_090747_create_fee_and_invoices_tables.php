<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fee_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Comprehensive Day Care & Therapy Package, Speech 10-Session Bundle, OT Package
            $table->text('description')->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('billing_cycle')->default('Monthly'); // Monthly, Quarterly, Per Session, Annual
            $table->unsignedSmallInteger('sessions_count')->default(0); // e.g. 10 Speech sessions
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->unique();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('fee_package_id')->nullable()->constrained('fee_packages')->nullOnDelete();
            $table->string('item_description');
            $table->decimal('amount', 10, 2);
            $table->date('invoice_date');
            $table->date('due_date');
            $table->date('paid_date')->nullable();
            $table->string('payment_method')->nullable(); // Cash, UPI / GPay, Card, Bank Transfer
            $table->string('transaction_reference')->nullable();
            $table->string('status')->default('pending'); // pending, paid, overdue, cancelled
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('fee_packages');
    }
};
