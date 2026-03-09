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
            if (!Schema::hasColumn('jobs', 'position')) {
                $table->string('position')->nullable();
            }
            if (!Schema::hasColumn('jobs', 'description')) {
                $table->text('description')->nullable();
            }
            if (!Schema::hasColumn('jobs', 'qualifications')) {
                $table->text('qualifications')->nullable();
            }
            if (!Schema::hasColumn('jobs', 'location')) {
                $table->string('location')->nullable();
            }
            if (!Schema::hasColumn('jobs', 'employment_type')) {
                $table->enum('employment_type', ['Full Time', 'Part Time', 'Contract'])->nullable();
            }
            if (!Schema::hasColumn('jobs', 'email')) {
                $table->string('email')->nullable();
            }
            if (!Schema::hasColumn('jobs', 'is_active')) {
                $table->boolean('is_active')->default(true)->nullable();
            }
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
