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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default('active');
            $table->foreignId('parent_category_id')->nullable()->constrained('categories')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('sub_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('name');
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });

        Schema::create('generics', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('dosage')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });

        Schema::create('manufacturers', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->text('address')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('license_info')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });

        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('manufacturer_id')->nullable()->constrained('manufacturers')->onDelete('cascade');
            $table->string('country')->nullable();
            $table->string('contact')->nullable();
            $table->string('website')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });

        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('symbol')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->unique()->nullable();
            $table->string('barcode')->unique()->nullable();
            $table->string('name');
            $table->foreignId('generic_id')->nullable()->constrained('generics')->onDelete('set null');
            $table->foreignId('brand_id')->nullable()->constrained('brands')->onDelete('set null');
            $table->foreignId('manufacturer_id')->nullable()->constrained('manufacturers')->onDelete('set null');
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->foreignId('sub_category_id')->nullable()->constrained('sub_categories')->onDelete('set null');
            $table->foreignId('unit_id')->nullable()->constrained('units')->onDelete('set null');
            
            $table->string('medicine_type')->nullable(); // Tablet, Capsule, Syrup, etc.
            $table->string('strength')->nullable();
            $table->string('dosage_form')->nullable();
            $table->string('pack_size')->nullable();
            
            $table->decimal('purchase_price', 18, 2)->default(0);
            $table->decimal('sale_price', 18, 2)->default(0);
            $table->decimal('wholesale_price', 18, 2)->default(0);
            $table->decimal('mrp', 18, 2)->default(0);
            $table->decimal('tax', 5, 2)->default(0);
            $table->decimal('discount', 5, 2)->default(0);
            
            $table->integer('min_stock')->default(0);
            $table->integer('reorder_level')->default(0);
            $table->boolean('prescription_required')->default(false);
            $table->text('description')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });

        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('image_url');
            $table->boolean('is_primary')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('products');
        Schema::dropIfExists('units');
        Schema::dropIfExists('brands');
        Schema::dropIfExists('manufacturers');
        Schema::dropIfExists('generics');
        Schema::dropIfExists('sub_categories');
        Schema::dropIfExists('categories');
    }
};
