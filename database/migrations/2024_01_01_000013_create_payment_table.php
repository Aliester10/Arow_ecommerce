<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment', function (Blueprint $table) {
            $table->id('id_payment');
            $table->unsignedBigInteger('id_order');
            $table->string('metode'); // transfer, credit_card, etc.
            $table->decimal('amount', 15, 2);
            $table->string('status')->default('pending'); // pending, paid, failed
            $table->string('bukti_transfer')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->foreign('id_order')->references('id_order')->on('order')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment');
    }
};
