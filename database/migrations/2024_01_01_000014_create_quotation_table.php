<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quotation', function (Blueprint $table) {
            $table->id('id_quotation');
            $table->unsignedBigInteger('id_order');
            $table->timestamp('sent_at')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('status_quotation')->default('draft'); // draft, sent, accepted, rejected
            $table->timestamps();

            $table->foreign('id_order')->references('id_order')->on('order')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotation');
    }
};
