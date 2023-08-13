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
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('voucher_id')->nullable();
            $table->unsignedBigInteger('address_id')->nullable();
            $table->string('trans_code')->nullable();
            $table->unsignedBigInteger('payment')->nullable();
            $table->enum('status', [1, 2, 3, 4, 5])->nullable()->default(1)->comment('1 for Ordered, 2 for Paid, 3 for Packing, 4 for Sent and 5 for Delivered');
            $table->boolean('flag_active')->nullable()->default(true);
            $table->string('order_note')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('voucher_id')->references('id')->on('vouchers')->onDelete('set null');
            $table->foreign('address_id')->references('id')->on('address_users')->onDelete('set null');
            $table->foreign('payment')->references('id')->on('payment_methods')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
