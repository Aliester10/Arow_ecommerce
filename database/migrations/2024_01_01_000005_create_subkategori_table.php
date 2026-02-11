<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subkategori', function (Blueprint $table) {
            $table->id('id_subkategori');
            $table->unsignedBigInteger('id_kategori');
            $table->string('nama_kategori'); // Subcategory Name
            $table->timestamps();

            $table->foreign('id_kategori')->references('id_kategori')->on('kategori')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subkategori');
    }
};
