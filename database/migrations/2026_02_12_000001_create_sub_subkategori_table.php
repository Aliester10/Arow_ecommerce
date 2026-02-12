<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sub_subkategori', function (Blueprint $table) {
            $table->id('id_sub_subkategori');
            $table->unsignedBigInteger('id_subkategori');
            $table->string('nama_sub_subkategori');
            $table->timestamps();

            $table->foreign('id_subkategori')
                ->references('id_subkategori')
                ->on('subkategori')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_subkategori');
    }
};
