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
        // Use DB statement to avoid needing doctrine/dbal
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `order` MODIFY COLUMN destination_city_id VARCHAR(20) DEFAULT NULL;");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `order` MODIFY COLUMN destination_city_id INT DEFAULT NULL;");
    }
};
