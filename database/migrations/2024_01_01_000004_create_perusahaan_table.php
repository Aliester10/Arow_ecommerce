<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perusahaan', function (Blueprint $table) {
            $table->id('id_perusahaan');
            $table->string('nama_perusahaan');
            $table->text('visi')->nullable();
            $table->text('misi')->nullable();
            $table->text('alamat_perusahaan')->nullable();
            $table->string('notelp_perusahaan')->nullable();
            $table->string('email_perusahaan')->nullable();
            $table->string('website_perusahaan')->nullable();
            $table->string('logo_perusahaan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perusahaan');
    }
};
