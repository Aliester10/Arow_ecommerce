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
        // Drop legacy tables if they exist
        Schema::dropIfExists('special_deal_products');
        Schema::dropIfExists('special_deals');

        // Create promo_campaigns table
        Schema::create('promo_campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->string('banner')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('status')->default('aktif'); // aktif / nonaktif
            $table->timestamps();
        });

        // Create promo_campaign_products table
        Schema::create('promo_campaign_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('promo_campaign_id')->constrained('promo_campaigns')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('produk', 'id_produk')->onDelete('cascade');
            $table->string('discount_type'); // percent / nominal
            $table->decimal('discount_value', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promo_campaign_products');
        Schema::dropIfExists('promo_campaigns');
    }
};
