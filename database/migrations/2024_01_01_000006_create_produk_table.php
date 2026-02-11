<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id('id_produk');
            $table->unsignedBigInteger('id_brand');
            $table->unsignedBigInteger('id_subkategori');
            $table->string('nama_produk');
            $table->text('deskripsi_produk')->nullable();
            $table->decimal('harga_produk', 15, 2);
            $table->integer('stok_produk');
            $table->string('status_produk')->default('active');
            $table->decimal('berat_produk', 10, 2)->nullable(); // Weight in grams/kg
            $table->timestamps();

            $table->foreign('id_brand')->references('id_brand')->on('brand')->onDelete('cascade');
            $table->foreign('id_subkategori')->references('id_subkategori')->on('subkategori')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
