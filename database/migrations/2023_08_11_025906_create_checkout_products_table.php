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
        Schema::create('checkout_products', function (Blueprint $table) {
            $table->id();
            $table->uuid('trans_id');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->integer('qty')->nullable();
            $table->decimal('price')->nullable();
            $table->decimal('sale')->nullable();
            $table->timestamps();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
            $table->foreign('trans_id')->references('id')->on('transactions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkout_products');
    }
};
