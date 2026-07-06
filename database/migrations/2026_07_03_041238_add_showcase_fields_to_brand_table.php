<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('brand', function (Blueprint $table) {
            $table->string('banner_image', 255)->nullable()->after('gambar_background');
            $table->string('banner_title', 255)->nullable()->after('banner_image');
            $table->text('banner_subtitle')->nullable()->after('banner_title');
            $table->string('banner_button_text', 100)->nullable()->after('banner_subtitle');
            $table->string('banner_button_link', 255)->nullable()->after('banner_button_text');
            
            $table->string('overlay_color', 20)->default('#0EA5E9')->change();
            
            $table->boolean('show_product_count')->default(true)->after('overlay_opacity');
            $table->boolean('show_category_count')->default(true)->after('show_product_count');
            $table->boolean('show_official_badge')->default(true)->after('show_category_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('brand', function (Blueprint $table) {
            $table->dropColumn([
                'banner_image',
                'banner_title',
                'banner_subtitle',
                'banner_button_text',
                'banner_button_link',
                'show_product_count',
                'show_category_count',
                'show_official_badge'
            ]);
            
            $table->string('overlay_color', 20)->default('#B7E3F6')->change();
        });
    }
};
