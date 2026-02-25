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
        Schema::create('special_deal_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('special_deal_id')->constrained()->onDelete('cascade');
            $table->foreignId('id_produk')->references('id_produk')->on('produk')->onDelete('cascade');
            $table->integer('discount_percentage')->min(1)->max(100);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->unique(['special_deal_id', 'id_produk']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('special_deal_products');
    }
};
