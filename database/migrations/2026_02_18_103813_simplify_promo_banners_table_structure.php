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
            $table->dropColumn(['position', 'title', 'subtitle', 'link']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('promo_banners', function (Blueprint $table) {
            $table->integer('position')->default(0)->after('gambar_promo_banner');
            $table->string('title')->nullable()->after('position');
            $table->string('subtitle')->nullable()->after('title');
            $table->string('link')->nullable()->after('subtitle');
        });
    }
};
