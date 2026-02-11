<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order', function (Blueprint $table) {
            $table->id('id_order');
            $table->unsignedBigInteger('id_user');
            $table->dateTime('tanggal_order');
            $table->decimal('total_harga', 15, 2);
            $table->string('status_order')->default('pending'); // pending, paid, shipped, completed, cancelled
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order');
    }
};
