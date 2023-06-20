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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('short_desc')->nullable();
            $table->text('description')->nullable();
            $table->decimal('regular_price')->nullable();
            $table->decimal('sale_price')->nullable();
            $table->string('sku')->nullable();
            $table->boolean('featured')->default(false);
            $table->unsignedInteger('quantity')->default(0);
            $table->enum('product_for', ['i', 'e'])->nullable()->comment('i for Import and e for Export product');
            $table->bigInteger('category_id')->unsigned()->nullable();
            $table->bigInteger('image_id')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('image_id')->references('id')->on('image_products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
