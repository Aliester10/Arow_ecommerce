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
        Schema::create('integrated_solutions', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Integrated Solutions for Modern Businesses');
            $table->string('background_image')->nullable();
            $table->string('button_text')->default('See Now');
            $table->string('button_color')->default('#FF5F57');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('integrated_solution_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('integrated_solution_id')->constrained('integrated_solutions')->onDelete('cascade');
            $table->foreignId('kategori_id')->nullable()->constrained('kategori', 'id_kategori')->onDelete('cascade');
            $table->string('category_image')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('integrated_solution_categories');
        Schema::dropIfExists('integrated_solutions');
    }
};
