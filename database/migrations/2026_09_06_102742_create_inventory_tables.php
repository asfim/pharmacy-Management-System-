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
        Schema::create('stock_balances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained('branches')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('batch_id')->nullable()->constrained('batches')->onDelete('cascade');
            $table->foreignId('location_id')->nullable()->constrained('locations')->onDelete('set null');
            $table->integer('qty_on_hand')->default(0);
            $table->integer('reserved_qty')->default(0);
            $table->integer('damaged_qty')->default(0);
            $table->timestamps();
            
            $table->unique(['branch_id', 'product_id', 'batch_id', 'location_id'], 'stock_balance_unique');
        });

        Schema::create('stock_ledger', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained('branches')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('batch_id')->nullable()->constrained('batches')->onDelete('cascade');
            $table->string('transaction_type');
            $table->string('reference_type')->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->integer('qty_in')->default(0);
            $table->integer('qty_out')->default(0);
            $table->integer('balance_after')->default(0);
            $table->decimal('unit_cost', 18, 2)->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });

        Schema::create('stock_adjustments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained('branches')->onDelete('cascade');
            $table->date('adjustment_date');
            $table->string('reason')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });

        Schema::create('stock_adjustment_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('adjustment_id')->constrained('stock_adjustments')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('batch_id')->nullable()->constrained('batches')->onDelete('cascade');
            $table->integer('system_qty')->default(0);
            $table->integer('physical_qty')->default(0);
            $table->integer('difference_qty')->default(0);
            $table->string('reason')->nullable();
            $table->timestamps();
        });

        Schema::create('damage_wastage', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained('branches')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('batch_id')->nullable()->constrained('batches')->onDelete('cascade');
            $table->integer('quantity');
            $table->string('reason')->nullable();
            $table->decimal('cost', 18, 2)->default(0);
            $table->date('date');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamps();
        });

        Schema::create('stock_transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('source_branch_id')->constrained('branches')->onDelete('cascade');
            $table->foreignId('destination_branch_id')->constrained('branches')->onDelete('cascade');
            $table->string('transfer_no')->unique();
            $table->string('status')->default('pending');
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('received_at')->nullable();
            $table->timestamps();
        });

        Schema::create('stock_transfer_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transfer_id')->constrained('stock_transfers')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('batch_id')->nullable()->constrained('batches')->onDelete('cascade');
            $table->integer('quantity');
            $table->integer('received_quantity')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_transfer_items');
        Schema::dropIfExists('stock_transfers');
        Schema::dropIfExists('damage_wastage');
        Schema::dropIfExists('stock_adjustment_items');
        Schema::dropIfExists('stock_adjustments');
        Schema::dropIfExists('stock_ledger');
        Schema::dropIfExists('stock_balances');
    }
};
