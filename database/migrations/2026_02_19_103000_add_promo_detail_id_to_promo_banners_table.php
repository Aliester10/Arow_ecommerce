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
        Schema::table('promo_banners', function (Blueprint $table) {
            $table->unsignedBigInteger('id_promo_detail')->nullable()->after('gambar_promo_banner');
            $table->foreign('id_promo_detail')->references('id_promo_detail')->on('promo_details')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('promo_banners', function (Blueprint $table) {
            $table->dropForeign(['id_promo_detail']);
            $table->dropColumn('id_promo_detail');
        });
    }
};
