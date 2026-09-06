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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained('branches')->onDelete('cascade');
            $table->string('name');
            $table->string('phone');
            $table->text('address')->nullable();
            $table->date('joining_date')->nullable();
            $table->decimal('salary', 18, 2)->default(0);
            $table->unsignedBigInteger('role_id')->nullable(); // Reference to role if needed conceptually
            $table->string('status')->default('active');
            $table->timestamps();
        });

        Schema::create('attendance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->date('date');
            $table->string('status'); // present, absent, late, half_day, leave
            $table->time('check_in')->nullable();
            $table->time('check_out')->nullable();
            $table->string('note')->nullable();
            $table->timestamps();
        });

        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('leave_type');
            $table->string('status')->default('pending');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamps();
        });

        Schema::create('payroll', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->foreignId('branch_id')->constrained('branches')->onDelete('cascade');
            $table->string('month'); // e.g., '2023-10'
            $table->decimal('basic_salary', 18, 2)->default(0);
            $table->decimal('allowance', 18, 2)->default(0);
            $table->decimal('bonus', 18, 2)->default(0);
            $table->decimal('overtime', 18, 2)->default(0);
            $table->decimal('deductions', 18, 2)->default(0);
            $table->decimal('advance', 18, 2)->default(0);
            $table->decimal('absent_deduction', 18, 2)->default(0);
            $table->decimal('net_salary', 18, 2)->default(0);
            $table->string('status')->default('pending');
            $table->timestamps();
        });

        Schema::create('salary_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payroll_id')->constrained('payroll')->onDelete('cascade');
            $table->foreignId('account_id')->constrained('accounts')->onDelete('cascade');
            $table->decimal('amount', 18, 2);
            $table->date('payment_date');
            $table->string('reference')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary_payments');
        Schema::dropIfExists('payroll');
        Schema::dropIfExists('leave_requests');
        Schema::dropIfExists('attendance');
        Schema::dropIfExists('employees');
    }
};
