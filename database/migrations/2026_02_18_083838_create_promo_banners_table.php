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
        Schema::create('promo_banners', function (Blueprint $table) {
            $table->id('id_promo_banner');
            $table->string('gambar_promo_banner');
            $table->enum('type', ['promo_large', 'promo_small']); // promo_large (kiri), promo_small (kanan)
            $table->integer('position')->default(0);
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('link'); // Required for promo banners
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promo_banners');
    }
};
