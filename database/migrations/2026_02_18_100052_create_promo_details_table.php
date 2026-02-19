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
        Schema::create('promo_details', function (Blueprint $table) {
            $table->id('id_promo_detail');
            $table->unsignedBigInteger('id_promo_banner');
            $table->string('judul_detail');
            $table->text('deskripsi')->nullable();
            $table->string('gambar_tambahan')->nullable();
            $table->string('syarat_ketentuan')->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->string('kode_promo')->nullable();
            $table->decimal('diskon_persen', 5, 2)->nullable();
            $table->decimal('diskon_nominal', 10, 2)->nullable();
            $table->integer('min_pembelian')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
            
            $table->foreign('id_promo_banner')->references('id_promo_banner')->on('promo_banners')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promo_details');
    }
};
