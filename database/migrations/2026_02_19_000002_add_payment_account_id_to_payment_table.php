<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payment', function (Blueprint $table) {
            $table->unsignedBigInteger('payment_account_id')->nullable()->after('id_order');
            $table->index('payment_account_id');
            $table->foreign('payment_account_id')
                ->references('id')
                ->on('payment_accounts')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('payment', function (Blueprint $table) {
            $table->dropForeign(['payment_account_id']);
            $table->dropIndex(['payment_account_id']);
            $table->dropColumn('payment_account_id');
        });
    }
};
