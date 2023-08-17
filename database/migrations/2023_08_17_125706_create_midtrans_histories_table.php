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
        Schema::create('midtrans_histories', function (Blueprint $table) {
            $table->id();
            $table->uuid('trans_id')->nullable();
            $table->string('status')->nullable();
            $table->string('status_code')->nullable();
            $table->json('response')->nullable();
            $table->timestamps();
            $table->foreign('trans_id')->references('id')->on('transactions')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('midtrans_histories');
    }
};
