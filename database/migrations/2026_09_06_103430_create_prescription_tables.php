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
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->string('prescription_no')->unique();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('doctor_id')->nullable()->constrained('doctors')->onDelete('set null');
            $table->date('prescription_date');
            $table->string('image_file')->nullable();
            $table->string('verification_status')->default('pending');
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('prescription_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prescription_id')->constrained('prescriptions')->onDelete('cascade');
            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('set null');
            $table->string('dose')->nullable();
            $table->string('frequency')->nullable();
            $table->string('duration')->nullable();
            $table->text('instructions')->nullable();
            $table->integer('quantity')->default(0);
            $table->timestamps();
        });

        Schema::create('order_prescriptions', function (Blueprint $table) {
            $table->foreignId('order_id')->constrained('online_orders')->onDelete('cascade');
            $table->foreignId('prescription_id')->constrained('prescriptions')->onDelete('cascade');
            $table->primary(['order_id', 'prescription_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_prescriptions');
        Schema::dropIfExists('prescription_items');
        Schema::dropIfExists('prescriptions');
    }
};
