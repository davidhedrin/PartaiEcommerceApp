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
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->uuid('trans_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('va')->nullable();
            $table->decimal('amounts')->nullable();
            $table->unsignedBigInteger('payment_id')->nullable();
            $table->json('midtrans_response')->nullable();
            $table->dateTime('payed_date')->nullable();
            $table->dateTime('shipment_date')->nullable();
            $table->dateTime('finish_date')->nullable();
            $table->dateTime('expiry_time')->nullable();
            $table->timestamps();
            $table->foreign('trans_id')->references('id')->on('transactions')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('payment_id')->references('id')->on('payment_methods')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};
