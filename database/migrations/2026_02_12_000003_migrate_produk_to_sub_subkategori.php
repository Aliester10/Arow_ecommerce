<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('sub_subkategori')) {
            return;
        }

        // 1) Create default sub-subkategori for every subkategori (if not exists)
        $subkategoris = DB::table('subkategori')->select('id_subkategori', 'nama_subkategori')->get();

        foreach ($subkategoris as $sub) {
            $exists = DB::table('sub_subkategori')
                ->where('id_subkategori', $sub->id_subkategori)
                ->exists();

            if (!$exists) {
                DB::table('sub_subkategori')->insert([
                    'id_subkategori' => $sub->id_subkategori,
                    'nama_sub_subkategori' => $sub->nama_subkategori,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // 2) Add new FK column to produk
        Schema::table('produk', function (Blueprint $table) {
            if (!Schema::hasColumn('produk', 'id_sub_subkategori')) {
                $table->unsignedBigInteger('id_sub_subkategori')->nullable()->after('id_brand');
            }
        });

        // 3) Map existing produk.id_subkategori -> produk.id_sub_subkategori using default sub-subkategori
        if (Schema::hasColumn('produk', 'id_subkategori')) {
            $mapping = DB::table('sub_subkategori')
                ->select('id_subkategori', DB::raw('MIN(id_sub_subkategori) as id_sub_subkategori'))
                ->groupBy('id_subkategori')
                ->pluck('id_sub_subkategori', 'id_subkategori');

            foreach ($mapping as $idSubkategori => $idSubSubkategori) {
                DB::table('produk')
                    ->where('id_subkategori', $idSubkategori)
                    ->update(['id_sub_subkategori' => $idSubSubkategori]);
            }
        }

        // 4) Backfill required columns & normalize status
        if (Schema::hasColumn('produk', 'deskripsi_produk')) {
            DB::table('produk')->whereNull('deskripsi_produk')->update(['deskripsi_produk' => '']);
        }
        if (Schema::hasColumn('produk', 'berat_produk')) {
            DB::table('produk')->whereNull('berat_produk')->update(['berat_produk' => 0]);
        }
        if (Schema::hasColumn('produk', 'status_produk')) {
            DB::table('produk')->whereIn('status_produk', ['active', 'aktif'])->update(['status_produk' => 'aktif']);
            DB::table('produk')->whereIn('status_produk', ['inactive', 'nonaktif', 'non-active', 'non_active'])->update(['status_produk' => 'nonaktif']);
            DB::table('produk')->whereNotIn('status_produk', ['aktif', 'nonaktif'])->update(['status_produk' => 'aktif']);
        }

        // 5) Enforce schema changes on produk (using raw SQL to avoid doctrine/dbal)
        DB::statement("ALTER TABLE `produk` MODIFY `deskripsi_produk` TEXT NOT NULL");
        DB::statement("ALTER TABLE `produk` MODIFY `berat_produk` DECIMAL(10,2) NOT NULL DEFAULT 0");
        DB::statement("ALTER TABLE `produk` MODIFY `status_produk` ENUM('aktif','nonaktif') NOT NULL DEFAULT 'aktif'");
        DB::statement("ALTER TABLE `produk` MODIFY `harga_produk` DECIMAL(15,2) NOT NULL");
        DB::statement("ALTER TABLE `produk` MODIFY `stok_produk` INT NOT NULL");

        if (!Schema::hasColumn('produk', 'gambar_produk')) {
            Schema::table('produk', function (Blueprint $table) {
                $table->string('gambar_produk')->nullable()->after('deskripsi_produk');
            });
        }

        // 6) Add FK constraint to produk.id_sub_subkategori (ignore if already exists)
        try {
            Schema::table('produk', function (Blueprint $table) {
                if (Schema::hasColumn('produk', 'id_sub_subkategori')) {
                    $table->foreign('id_sub_subkategori')
                        ->references('id_sub_subkategori')
                        ->on('sub_subkategori')
                        ->onUpdate('cascade')
                        ->restrictOnDelete();
                }
            });
        } catch (Throwable $e) {
            // ignore
        }

        // 7) Make id_sub_subkategori NOT NULL after backfill
        DB::table('produk')->whereNull('id_sub_subkategori')->update([
            'id_sub_subkategori' => DB::table('sub_subkategori')->min('id_sub_subkategori'),
        ]);
        DB::statement("ALTER TABLE `produk` MODIFY `id_sub_subkategori` BIGINT UNSIGNED NOT NULL");

        // 8) Drop old FK + column id_subkategori
        if (Schema::hasColumn('produk', 'id_subkategori')) {
            try {
                Schema::table('produk', function (Blueprint $table) {
                    $table->dropForeign(['id_subkategori']);
                });
            } catch (Throwable $e) {
                // ignore
            }

            Schema::table('produk', function (Blueprint $table) {
                if (Schema::hasColumn('produk', 'id_subkategori')) {
                    $table->dropColumn('id_subkategori');
                }
            });
        }
    }

    public function down(): void
    {
        // Re-add id_subkategori
        Schema::table('produk', function (Blueprint $table) {
            if (!Schema::hasColumn('produk', 'id_subkategori')) {
                $table->unsignedBigInteger('id_subkategori')->nullable()->after('id_brand');
            }
        });

        // Map produk.id_sub_subkategori -> produk.id_subkategori
        if (Schema::hasColumn('produk', 'id_sub_subkategori') && Schema::hasTable('sub_subkategori')) {
            $subSubs = DB::table('sub_subkategori')->select('id_sub_subkategori', 'id_subkategori')->get();
            foreach ($subSubs as $row) {
                DB::table('produk')
                    ->where('id_sub_subkategori', $row->id_sub_subkategori)
                    ->update(['id_subkategori' => $row->id_subkategori]);
            }
        }

        // Drop FK + column id_sub_subkategori
        if (Schema::hasColumn('produk', 'id_sub_subkategori')) {
            try {
                Schema::table('produk', function (Blueprint $table) {
                    $table->dropForeign(['id_sub_subkategori']);
                });
            } catch (Throwable $e) {
                // ignore
            }

            Schema::table('produk', function (Blueprint $table) {
                $table->dropColumn('id_sub_subkategori');
            });
        }

        // Add FK back for id_subkategori
        Schema::table('produk', function (Blueprint $table) {
            if (Schema::hasColumn('produk', 'id_subkategori')) {
                $table->foreign('id_subkategori')
                    ->references('id_subkategori')
                    ->on('subkategori')
                    ->onUpdate('cascade')
                    ->cascadeOnDelete();
            }
        });

        // Leave other column type changes as-is to avoid destructive rollback.
    }
};
