<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update existing data: change 'main' type to 'slider'
        \DB::table('banner')
            ->where('type', 'main')
            ->update(['type' => 'slider']);

        // Ensure link is null for slider banners (they should not be clickable)
        \DB::table('banner')
            ->where('type', 'slider')
            ->update(['link' => null]);

        // For promo banners, ensure they have valid links (set to empty string if null)
        \DB::table('banner')
            ->whereIn('type', ['promo_large', 'promo_small'])
            ->whereNull('link')
            ->update(['link' => '']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert slider banners back to main type
        \DB::table('banner')
            ->where('type', 'slider')
            ->update(['type' => 'main']);
    }
};
