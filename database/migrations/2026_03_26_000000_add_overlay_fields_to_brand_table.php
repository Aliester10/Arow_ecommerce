<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('brand', function (Blueprint $table) {
            $table->string('overlay_color', 20)->default('#B7E3F6')->after('gambar_background');
            $table->integer('overlay_opacity')->default(70)->after('overlay_color');
        });

        // Seed default overlay colors based on brand names
        DB::table('brand')->where('nama_brand', 'like', '%living%')->update([
            'overlay_color' => '#B7E3F6',
            'overlay_opacity' => 70
        ]);

        DB::table('brand')->where('nama_brand', 'like', '%edu%')->update([
            'overlay_color' => '#D7E6D0',
            'overlay_opacity' => 70
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('brand', function (Blueprint $table) {
            $table->dropColumn(['overlay_color', 'overlay_opacity']);
        });
    }
};
