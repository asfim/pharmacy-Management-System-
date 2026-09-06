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
        Schema::create('online_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_no')->unique();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('branch_id')->nullable()->constrained('branches')->onDelete('set null');
            $table->string('status')->default('pending');
            $table->string('payment_status')->default('unpaid');
            $table->string('fulfillment_status')->default('unfulfilled');
            $table->decimal('subtotal', 18, 2)->default(0);
            $table->decimal('discount', 18, 2)->default(0);
            $table->decimal('delivery_charge', 18, 2)->default(0);
            $table->decimal('vat', 18, 2)->default(0);
            $table->decimal('total', 18, 2)->default(0);
            $table->foreignId('address_id')->nullable()->constrained('customer_addresses')->onDelete('set null');
            $table->boolean('prescription_required')->default(false);
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('online_orders')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('unit_price', 18, 2);
            $table->decimal('discount', 18, 2)->default(0);
            $table->decimal('vat', 18, 2)->default(0);
            $table->decimal('total', 18, 2);
            $table->timestamps();
        });

        Schema::create('order_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('online_orders')->onDelete('cascade');
            $table->foreignId('account_id')->nullable()->constrained('accounts')->onDelete('set null');
            $table->string('gateway')->nullable();
            $table->string('transaction_id')->nullable();
            $table->decimal('amount', 18, 2);
            $table->string('status')->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });

        Schema::create('order_status_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('online_orders')->onDelete('cascade');
            $table->string('old_status')->nullable();
            $table->string('new_status');
            $table->unsignedBigInteger('changed_by')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });

        Schema::create('order_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('online_orders')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->text('note');
            $table->timestamps();
        });

        Schema::create('delivery_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('online_orders')->onDelete('cascade');
            $table->foreignId('delivery_staff_id')->nullable()->constrained('employees')->onDelete('set null');
            $table->foreignId('address_id')->nullable()->constrained('customer_addresses')->onDelete('set null');
            $table->decimal('delivery_charge', 18, 2)->default(0);
            $table->string('zone')->nullable();
            $table->string('status')->default('pending');
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamps();
        });

        Schema::create('refunds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('online_orders')->onDelete('cascade');
            $table->foreignId('payment_id')->nullable()->constrained('order_payments')->onDelete('set null');
            $table->decimal('amount', 18, 2);
            $table->string('reason')->nullable();
            $table->string('status')->default('pending');
            $table->unsignedBigInteger('processed_by')->nullable();
            $table->timestamps();
        });

        Schema::create('returns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('online_orders')->onDelete('cascade');
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->string('reason')->nullable();
            $table->string('status')->default('pending');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamps();
        });

        Schema::create('return_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('return_id')->constrained('returns')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('amount', 18, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('return_items');
        Schema::dropIfExists('returns');
        Schema::dropIfExists('refunds');
        Schema::dropIfExists('delivery_orders');
        Schema::dropIfExists('order_notes');
        Schema::dropIfExists('order_status_history');
        Schema::dropIfExists('order_payments');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('online_orders');
    }
};
