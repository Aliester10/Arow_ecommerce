<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kategori', function (Blueprint $table) {
            if (!Schema::hasColumn('kategori', 'icon_kategori')) {
                $table->string('icon_kategori')->nullable()->after('nama_kategori');
            }
        });
    }

    public function down(): void
    {
        Schema::table('kategori', function (Blueprint $table) {
            if (Schema::hasColumn('kategori', 'icon_kategori')) {
                $table->dropColumn('icon_kategori');
            }
        });
    }
};
