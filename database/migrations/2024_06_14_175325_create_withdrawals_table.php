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
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
            ->constrained()
            ->onDelete('cascade');
            $table->string('type');
            $table->integer('amount');
            $table->string('asset')->nullable();
            $table->string('address')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('account_name')->nullable();
            $table->integer('account_number')->nullable();
            $table->string('paypal_address')->nullable();
            $table->integer('ref');
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawals');
    }
};
