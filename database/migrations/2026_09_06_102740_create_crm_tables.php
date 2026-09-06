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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->date('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('customer_type')->default('regular');
            $table->decimal('opening_due', 18, 2)->default(0);
            $table->decimal('credit_limit', 18, 2)->default(0);
            $table->string('status')->default('active');
            $table->timestamps();
        });

        Schema::create('customer_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->string('name');
            $table->string('phone');
            $table->string('address_line');
            $table->string('city')->nullable();
            $table->string('zone')->nullable();
            $table->string('postal_code')->nullable();
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });

        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('degree')->nullable();
            $table->string('specialization')->nullable();
            $table->string('bmdc_no')->nullable();
            $table->string('chamber')->nullable();
            $table->string('hospital_clinic')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
        Schema::dropIfExists('customer_addresses');
        Schema::dropIfExists('customers');
    }
};
