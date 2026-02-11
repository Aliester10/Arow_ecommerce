<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cart_detail', function (Blueprint $table) {
            $table->id('id_cart_detail');
            $table->unsignedBigInteger('id_cart');
            $table->unsignedBigInteger('id_produk');
            $table->integer('qty_cart');
            $table->decimal('harga', 15, 2);
            $table->timestamps();

            $table->foreign('id_cart')->references('id_cart')->on('cart')->onDelete('cascade');
            $table->foreign('id_produk')->references('id_produk')->on('produk')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_detail');
    }
};
