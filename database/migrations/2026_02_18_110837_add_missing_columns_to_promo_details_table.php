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
        Schema::table('promo_details', function (Blueprint $table) {
            $table->string('syarat_ketentuan')->nullable()->after('gambar_tambahan');
            $table->string('kode_promo')->nullable()->after('tanggal_selesai');
            $table->decimal('diskon_persen', 5, 2)->nullable()->after('kode_promo');
            $table->decimal('diskon_nominal', 10, 2)->nullable()->after('diskon_persen');
            $table->integer('min_pembelian')->nullable()->after('diskon_nominal');
            $table->boolean('aktif')->default(true)->after('min_pembelian');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('promo_details', function (Blueprint $table) {
            $table->dropColumn([
                'syarat_ketentuan',
                'kode_promo',
                'diskon_persen',
                'diskon_nominal',
                'min_pembelian',
                'aktif'
            ]);
        });
    }
};
