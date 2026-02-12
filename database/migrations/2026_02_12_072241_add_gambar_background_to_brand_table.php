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
        Schema::table('brand', function (Blueprint $table) {
            if (!Schema::hasColumn('brand', 'gambar_background')) {
                $table->string('gambar_background')->nullable()->after('logo_brand');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('brand', function (Blueprint $table) {
            if (Schema::hasColumn('brand', 'gambar_background')) {
                $table->dropColumn('gambar_background');
            }
        });
    }
};
