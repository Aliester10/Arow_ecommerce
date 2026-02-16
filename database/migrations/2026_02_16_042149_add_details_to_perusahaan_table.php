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
        Schema::table('perusahaan', function (Blueprint $table) {
            $table->string('phone_alt')->nullable()->after('notelp_perusahaan');
            $table->string('email_sales')->nullable()->after('email_perusahaan');
            $table->text('footer_description')->nullable()->after('misi');
            $table->string('facebook')->nullable()->after('website_perusahaan');
            $table->string('instagram')->nullable()->after('facebook');
            $table->string('twitter')->nullable()->after('instagram');
            $table->string('linkedin')->nullable()->after('twitter');
            $table->string('tiktok')->nullable()->after('linkedin');
            $table->string('member_of_image')->nullable()->after('logo_perusahaan');
        });
    }

    public function down(): void
    {
        Schema::table('perusahaan', function (Blueprint $table) {
            $table->dropColumn([
                'phone_alt',
                'email_sales',
                'footer_description',
                'facebook',
                'instagram',
                'twitter',
                'linkedin',
                'tiktok',
                'member_of_image'
            ]);
        });
    }
};
