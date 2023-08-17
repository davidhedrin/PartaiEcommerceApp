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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('code')->unique()->nullable();
            $table->string('payment_type')->nullable();
            $table->string('bank_transfer')->unique()->nullable();
            $table->integer('type')->nullable();
            $table->decimal('fee_fixed')->nullable();
            $table->double('fee_percent')->nullable();
            $table->string('img')->nullable();
            $table->boolean('flag_active')->nullable()->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
