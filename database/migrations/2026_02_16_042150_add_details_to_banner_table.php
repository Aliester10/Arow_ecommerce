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
        Schema::table('banner', function (Blueprint $table) {
            $table->string('type')->default('main')->after('gambar_banner'); // main, promo_large, promo_small
            $table->integer('position')->default(0)->after('type');
            $table->string('title')->nullable()->after('position');
            $table->string('subtitle')->nullable()->after('title');
            $table->string('link')->nullable()->after('subtitle');
            $table->boolean('active')->default(true)->after('link');
        });
    }

    public function down(): void
    {
        Schema::table('banner', function (Blueprint $table) {
            $table->dropColumn(['type', 'position', 'title', 'subtitle', 'link', 'active']);
        });
    }
};
