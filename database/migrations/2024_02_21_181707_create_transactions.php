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
            $table->id();
            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('transfer_from')->nullable();
            $table->unsignedBigInteger('transfer_to')->nullable();
            $table->decimal('transaction_amount', 10, 2);
            $table->decimal('closing_balance', 10, 2);
            $table->string('transaction_type');
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('account_id')->references('id')->on('users');
            $table->foreign('transfer_from')->references('id')->on('users');
            $table->foreign('transfer_to')->references('id')->on('users');
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
