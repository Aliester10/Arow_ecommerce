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
        Schema::table('footer_links', function (Blueprint $table) {
            $table->string('type')->default('text')->after('column_title'); // text or image
            $table->string('image_path')->nullable()->after('url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('footer_links', function (Blueprint $table) {
            $table->dropColumn(['type', 'image_path']);
        });
    }
};
