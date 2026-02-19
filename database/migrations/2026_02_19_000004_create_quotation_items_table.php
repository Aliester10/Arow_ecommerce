<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quotation_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_quotation');
            $table->unsignedBigInteger('id_produk')->nullable();
            $table->string('product_name')->nullable();
            $table->integer('qty')->default(1);
            $table->decimal('price', 15, 2)->default(0);
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->foreign('id_quotation')->references('id_quotation')->on('quotation')->onDelete('cascade');
            $table->foreign('id_produk')->references('id_produk')->on('produk')->nullOnDelete();

            $table->index(['id_quotation', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotation_items');
    }
};
