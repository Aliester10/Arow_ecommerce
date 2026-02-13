<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            if (!Schema::hasColumn('produk', 'sku_produk')) {
                $table->string('sku_produk')->nullable()->after('nama_produk');
            }
            if (!Schema::hasColumn('produk', 'tipe_produk')) {
                $table->string('tipe_produk')->nullable()->after('sku_produk');
            }
            if (!Schema::hasColumn('produk', 'asal_produk')) {
                $table->string('asal_produk')->nullable()->after('tipe_produk');
            }
            if (!Schema::hasColumn('produk', 'dimensi_produk')) {
                $table->string('dimensi_produk')->nullable()->after('asal_produk');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            $table->dropColumn(['sku_produk', 'tipe_produk', 'asal_produk', 'dimensi_produk']);
        });
    }
};
