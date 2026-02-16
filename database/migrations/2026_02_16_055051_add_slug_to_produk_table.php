<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('nama_produk');
        });

        // Populate slugs for existing products
        $products = \App\Models\Produk::all();
        foreach ($products as $product) {
            $baseSlug = Str::slug($product->nama_produk);
            $slug = $baseSlug;
            $counter = 1;
            while (\App\Models\Produk::where('slug', $slug)->where('id_produk', '!=', $product->id_produk)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }
            $product->slug = $slug;
            $product->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
