<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('order', function (Blueprint $table) {
            if (!Schema::hasColumn('order', 'shipping_cost')) {
                $table->integer('shipping_cost')->default(0)->after('total_harga');
            }
            if (!Schema::hasColumn('order', 'shipping_courier')) {
                $table->string('shipping_courier', 50)->nullable()->after('shipping_cost');
            }
            if (!Schema::hasColumn('order', 'shipping_service')) {
                $table->string('shipping_service', 100)->nullable()->after('shipping_courier');
            }
            if (!Schema::hasColumn('order', 'shipping_etd')) {
                $table->string('shipping_etd', 50)->nullable()->after('shipping_service');
            }
            if (!Schema::hasColumn('order', 'destination_city_id')) {
                $table->integer('destination_city_id')->nullable()->after('shipping_etd');
            }
        });
    }

    public function down(): void
    {
        Schema::table('order', function (Blueprint $table) {
            $columns = ['shipping_cost', 'shipping_courier', 'shipping_service', 'shipping_etd', 'destination_city_id'];
            foreach ($columns as $col) {
                if (Schema::hasColumn('order', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
