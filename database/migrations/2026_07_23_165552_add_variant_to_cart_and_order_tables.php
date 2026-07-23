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
        Schema::table('cart_detail', function (Blueprint $table) {
            $table->unsignedBigInteger('id_product_variant')->nullable()->after('id_produk');
            $table->foreign('id_product_variant')->references('id_variant')->on('product_variants')->onDelete('set null');
        });

        Schema::table('order_item', function (Blueprint $table) {
            $table->unsignedBigInteger('id_product_variant')->nullable()->after('id_produk');
            $table->json('variant_details')->nullable()->after('id_product_variant');
            $table->foreign('id_product_variant')->references('id_variant')->on('product_variants')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cart_detail', function (Blueprint $table) {
            $table->dropForeign(['id_product_variant']);
            $table->dropColumn('id_product_variant');
        });

        Schema::table('order_item', function (Blueprint $table) {
            $table->dropForeign(['id_product_variant']);
            $table->dropColumn(['id_product_variant', 'variant_details']);
        });
    }
};
