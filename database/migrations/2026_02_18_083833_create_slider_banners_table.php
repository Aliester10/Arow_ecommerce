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
        Schema::create('slider_banners', function (Blueprint $table) {
            $table->id('id_slider_banner');
            $table->string('gambar_slider_banner');
            $table->integer('position')->default(0);
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slider_banners');
    }
};
