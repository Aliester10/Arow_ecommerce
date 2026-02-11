<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ulasan', function (Blueprint $table) {
            $table->id('id_ulasan');
            $table->unsignedBigInteger('id_produk');
            $table->unsignedBigInteger('id_user');
            $table->integer('rating_ulasan');
            $table->text('komentar_ulasan')->nullable();
            $table->dateTime('tanggal_ulasan');
            $table->timestamps();

            $table->foreign('id_produk')->references('id_produk')->on('produk')->onDelete('cascade');
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ulasan');
    }
};
