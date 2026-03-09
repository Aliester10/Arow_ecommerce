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
        Schema::table('blog_posts', function (Blueprint $table) {
            // Rename existing columns to match our model
            if (Schema::hasColumn('blog_posts', 'thumbnail_image')) {
                $table->renameColumn('thumbnail_image', 'image');
            }
            
            // Handle status column conversion properly
            if (Schema::hasColumn('blog_posts', 'status')) {
                // First convert enum values to boolean, then rename
                \DB::statement("ALTER TABLE blog_posts ADD COLUMN is_published_temp BOOLEAN DEFAULT 0");
                \DB::statement("UPDATE blog_posts SET is_published_temp = CASE WHEN status = 'published' THEN 1 ELSE 0 END");
                \DB::statement("ALTER TABLE blog_posts DROP COLUMN status");
                \DB::statement("ALTER TABLE blog_posts CHANGE is_published_temp is_published BOOLEAN DEFAULT 0");
            }
            
            // Add missing columns
            if (!Schema::hasColumn('blog_posts', 'meta_title')) {
                $table->string('meta_title')->nullable();
            }
            
            if (!Schema::hasColumn('blog_posts', 'meta_description')) {
                $table->text('meta_description')->nullable();
            }
            
            if (!Schema::hasColumn('blog_posts', 'author_id')) {
                $table->foreignId('author_id')->nullable()->constrained('users')->onDelete('set null');
            }
            
            if (!Schema::hasColumn('blog_posts', 'views')) {
                $table->integer('views')->default(0);
            }
            
            // Drop columns we don't need
            if (Schema::hasColumn('blog_posts', 'category')) {
                $table->dropColumn('category');
            }
            
            if (Schema::hasColumn('blog_posts', 'author')) {
                $table->dropColumn('author');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            // Reverse the changes
            if (Schema::hasColumn('blog_posts', 'image')) {
                $table->renameColumn('image', 'thumbnail_image');
            }
            
            if (Schema::hasColumn('blog_posts', 'is_published')) {
                $table->renameColumn('is_published', 'status');
            }
            
            if (Schema::hasColumn('blog_posts', 'meta_title')) {
                $table->dropColumn('meta_title');
            }
            
            if (Schema::hasColumn('blog_posts', 'meta_description')) {
                $table->dropColumn('meta_description');
            }
            
            if (Schema::hasColumn('blog_posts', 'author_id')) {
                $table->dropForeign(['author_id']);
                $table->dropColumn('author_id');
            }
            
            if (Schema::hasColumn('blog_posts', 'views')) {
                $table->dropColumn('views');
            }
            
            // Add back original columns
            if (!Schema::hasColumn('blog_posts', 'category')) {
                $table->string('category')->nullable();
            }
            
            if (!Schema::hasColumn('blog_posts', 'author')) {
                $table->string('author')->nullable();
            }
        });
    }
};
