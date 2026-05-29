<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add indexes to categories table
        Schema::table('categories', function (Blueprint $table) {
            $table->index('status');
            $table->index('code');
            $table->index('name');
        });

        // Add indexes to sub_categories table
        Schema::table('sub_categories', function (Blueprint $table) {
            $table->index('status');
            $table->index('category_id');
            $table->index('code');
            $table->index('name');
        });

        // Add indexes to items table if not exists
        Schema::table('items', function (Blueprint $table) {
            $table->index('status');
            $table->index('category_id');
            $table->index('sub_category_id');
        });

        // Add composite index for common query pattern
        DB::statement('CREATE INDEX IF NOT EXISTS categories_status_code ON categories (status, code)');
        DB::statement('CREATE INDEX IF NOT EXISTS sub_categories_status_category ON sub_categories (status, category_id)');
        DB::statement('CREATE INDEX IF NOT EXISTS items_status_category ON items (status, category_id)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['code']);
            $table->dropIndex(['name']);
        });

        Schema::table('sub_categories', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['category_id']);
            $table->dropIndex(['code']);
            $table->dropIndex(['name']);
        });

        Schema::table('items', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['category_id']);
            $table->dropIndex(['sub_category_id']);
        });
    }
};
