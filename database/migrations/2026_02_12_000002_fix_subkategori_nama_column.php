<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subkategori', function (Blueprint $table) {
            if (!Schema::hasColumn('subkategori', 'nama_subkategori')) {
                $table->string('nama_subkategori')->default('')->after('id_kategori');
            }
        });

        if (Schema::hasColumn('subkategori', 'nama_kategori') && Schema::hasColumn('subkategori', 'nama_subkategori')) {
            DB::table('subkategori')->where('nama_subkategori', '')->update([
                'nama_subkategori' => DB::raw('nama_kategori'),
            ]);
        }

        Schema::table('subkategori', function (Blueprint $table) {
            if (Schema::hasColumn('subkategori', 'nama_kategori')) {
                $table->dropColumn('nama_kategori');
            }
        });
    }

    public function down(): void
    {
        Schema::table('subkategori', function (Blueprint $table) {
            if (!Schema::hasColumn('subkategori', 'nama_kategori')) {
                $table->string('nama_kategori')->default('')->after('id_kategori');
            }
        });

        if (Schema::hasColumn('subkategori', 'nama_kategori') && Schema::hasColumn('subkategori', 'nama_subkategori')) {
            DB::table('subkategori')->where('nama_kategori', '')->update([
                'nama_kategori' => DB::raw('nama_subkategori'),
            ]);
        }

        Schema::table('subkategori', function (Blueprint $table) {
            if (Schema::hasColumn('subkategori', 'nama_subkategori')) {
                $table->dropColumn('nama_subkategori');
            }
        });
    }
};
