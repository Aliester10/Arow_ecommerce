<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            if (!Schema::hasColumn('produk', 'id_kategori')) {
                $table->unsignedBigInteger('id_kategori')->nullable()->after('id_brand');
            }
            if (!Schema::hasColumn('produk', 'id_subkategori')) {
                $table->unsignedBigInteger('id_subkategori')->nullable()->after('id_kategori');
            }

            // Ensure id_sub_subkategori allows nulls
            $table->unsignedBigInteger('id_sub_subkategori')->nullable()->change();
        });

        // Add foreign keys only if they don't exist yet
        $foreignKeys = collect(DB::select("SELECT CONSTRAINT_NAME FROM information_schema.TABLE_CONSTRAINTS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'produk' AND CONSTRAINT_TYPE = 'FOREIGN KEY'"))->pluck('CONSTRAINT_NAME')->toArray();

        Schema::table('produk', function (Blueprint $table) use ($foreignKeys) {
            if (!in_array('produk_id_kategori_foreign', $foreignKeys)) {
                $table->foreign('id_kategori')->references('id_kategori')->on('kategori')->onUpdate('cascade')->nullOnDelete();
            }
            if (!in_array('produk_id_subkategori_foreign', $foreignKeys)) {
                $table->foreign('id_subkategori')->references('id_subkategori')->on('subkategori')->onUpdate('cascade')->nullOnDelete();
            }
        });

        // Backfill existing data
        $products = DB::table('produk')->whereNotNull('id_sub_subkategori')->whereNull('id_kategori')->get();
        foreach ($products as $product) {
            $subSub = DB::table('sub_subkategori')->where('id_sub_subkategori', $product->id_sub_subkategori)->first();
            if ($subSub) {
                $sub = DB::table('subkategori')->where('id_subkategori', $subSub->id_subkategori)->first();
                if ($sub) {
                    DB::table('produk')
                        ->where('id_produk', $product->id_produk)
                        ->update([
                            'id_subkategori' => $sub->id_subkategori,
                            'id_kategori' => $sub->id_kategori
                        ]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            $table->dropForeign(['id_kategori']);
            $table->dropForeign(['id_subkategori']);
            $table->dropColumn(['id_kategori', 'id_subkategori']);
        });
    }
};
