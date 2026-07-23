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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id('id_variant');
            $table->unsignedBigInteger('id_produk');
            $table->json('variant_combination'); // e.g., {"Color":"Red", "Capacity":"128GB"}
            $table->decimal('harga_produk', 15, 2);
            $table->integer('stok_produk');
            $table->string('sku_produk')->nullable();
            $table->string('gambar_produk')->nullable();
            $table->timestamps();

            $table->foreign('id_produk')->references('id_produk')->on('produk')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
