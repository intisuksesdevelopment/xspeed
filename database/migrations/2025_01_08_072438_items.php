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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('name');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('subcategory_id')->nullable();
            $table->unsignedBigInteger('warehouse_id')->nullable();
            $table->unsignedBigInteger('rack_id')->nullable();
            $table->decimal('basic_price', 10, 2);
            $table->decimal('sell_price', 10, 2);
            $table->integer('quantity');
            $table->string('unit');
            $table->string('color');
            $table->decimal('stock', 10, 2);
            $table->decimal('stock_min', 10, 2);
            $table->string('currency');
            $table->string('sku');
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->integer('status')->comment('0=active;1=deleted;')->default(0);
            $table->string('created_by')->nullable()->comment('username user who created the record');
            $table->string('updated_by')->nullable()->comment('username user who last updated the record');
            $table->timestamps();
            $table->text('history_log')->nullable();

            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('subcategory_id')->references('id')->on('sub_categories');
            $table->foreign('warehouse_id')->references('id')->on('warehouses');
            $table->foreign('rack_id')->references('id')->on('racks');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
