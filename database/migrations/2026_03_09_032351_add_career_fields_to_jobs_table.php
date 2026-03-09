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
        Schema::table('jobs', function (Blueprint $table) {
            $table->string('position')->nullable();
            $table->text('description')->nullable();
            $table->text('qualifications')->nullable();
            $table->string('location')->nullable();
            $table->enum('employment_type', ['Full Time', 'Part Time', 'Contract'])->nullable();
            $table->string('email')->nullable();
            $table->boolean('is_active')->default(true)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropColumn(['position', 'description', 'qualifications', 'location', 'employment_type', 'email', 'is_active']);
        });
    }
};
