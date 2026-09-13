<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->string('type', 30)->comment('promo|announcement|banner');
            $table->string('title')->nullable();
            $table->text('content');
            $table->string('code', 50)->nullable()->comment('kode promo, kosongkan kalau bukan promo');
            $table->string('link', 500)->nullable();
            $table->string('position', 30)->comment('product_top|product_bottom|home_top|home_bottom');
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};
