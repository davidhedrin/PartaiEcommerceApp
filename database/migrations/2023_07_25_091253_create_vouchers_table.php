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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->nullable();
            $table->enum('type', ['fixed', 'percent'])->nullable();
            $table->integer('value')->nullable();
            $table->integer('max_value_percent')->nullable();
            $table->date('exp_date')->nullable();
            $table->text('keterangan')->nullable();
            $table->boolean('product_discont')->nullable(false);
            $table->boolean('flag_active')->default(true);
            $table->integer('min_cart')->nullable();
            $table->enum('for_product', ['i', 'e'])->nullable()->comment('i for Import and e for Export product');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
