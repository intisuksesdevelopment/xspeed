<?php

use App\Models\Items;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Items::save();
        DB::table('items')->insert([
            ['uuid' => Str::uuid(), 'name' => 'Item 1', 'category_id' => 1, 'subcategory_id' => 1, 'warehouse_id' => 1, 'rack_id' => 1, 'basic_price' => 100.00, 'sell_price' => 150.00, 'quantity' => 10, 'unit' => 'pcs', 'color' => 'Red', 'stock' => 10.00, 'stock_min' => 2.00, 'currency' => 'USD', 'sku' => 'SKU001', 'desc' => 'Description for Item 1', 'image_url' => 'http://example.com/image1.jpg', 'status' => 0, 'created_by' => 'admin', 'updated_by' => 'admin', 'created_at' => now(), 'updated_at' => now(), 'history_log' => 'Created by admin'], ['uuid' => Str::uuid(), 'name' => 'Item 2', 'category_id' => 2, 'subcategory_id' => 2, 'warehouse_id' => 2, 'rack_id' => 2, 'basic_price' => 200.00, 'sell_price' => 250.00, 'quantity' => 20, 'unit' => 'pcs', 'color' => 'Blue', 'stock' => 20.00, 'stock_min' => 4.00, 'currency' => 'USD', 'sku' => 'SKU002', 'desc' => 'Description for Item 2', 'image_url' => 'http://example.com/image2.jpg', 'status' => 0, 'created_by' => 'admin', 'updated_by' => 'admin', 'created_at' => now(), 'updated_at' => now(), 'history_log' => 'Created by admin'],
            ['uuid' => Str::uuid(), 'name' => 'Item 3', 'category_id' => 3, 'subcategory_id' => 3, 'warehouse_id' => 3, 'rack_id' => 3, 'basic_price' => 300.00, 'sell_price' => 350.00, 'quantity' => 30, 'unit' => 'pcs', 'color' => 'Green', 'stock' => 30.00, 'stock_min' => 6.00, 'currency' => 'USD', 'sku' => 'SKU003', 'desc' => 'Description for Item 3', 'image_url' => 'http://example.com/image3.jpg', 'status' => 0, 'created_by' => 'admin', 'updated_by' => 'admin', 'created_at' => now(), 'updated_at' => now(), 'history_log' => 'Created by admin'], ['uuid' => Str::uuid(), 'name' => 'Item 4', 'category_id' => 4, 'subcategory_id' => 4, 'warehouse_id' => 4, 'rack_id' => 4, 'basic_price' => 400.00, 'sell_price' => 450.00, 'quantity' => 40, 'unit' => 'pcs', 'color' => 'Yellow', 'stock' => 40.00, 'stock_min' => 8.00, 'currency' => 'USD', 'sku' => 'SKU004', 'desc' => 'Description for Item 4', 'image_url' => 'http://example.com/image4.jpg', 'status' => 0, 'created_by' => 'admin', 'updated_by' => 'admin', 'created_at' => now(), 'updated_at' => now(), 'history_log' => 'Created by admin'],
            ['uuid' => Str::uuid(), 'name' => 'Item 5', 'category_id' => 5, 'subcategory_id' => 5, 'warehouse_id' => 5, 'rack_id' => 5, 'basic_price' => 500.00, 'sell_price' => 550.00, 'quantity' => 50, 'unit' => 'pcs', 'color' => 'Orange', 'stock' => 50.00, 'stock_min' => 10.00, 'currency' => 'USD', 'sku' => 'SKU005', 'desc' => 'Description for Item 5', 'image_url' => 'http://example.com/image5.jpg', 'status' => 0, 'created_by' => 'admin', 'updated_by' => 'admin', 'created_at' => now(), 'updated_at' => now(), 'history_log' => 'Created by admin'], ['uuid' => Str::uuid(), 'name' => 'Item 6', 'category_id' => 6, 'subcategory_id' => 6, 'warehouse_id' => 6, 'rack_id' => 6, 'basic_price' => 600.00, 'sell_price' => 650.00, 'quantity' => 60, 'unit' => 'pcs', 'color' => 'Purple', 'stock' => 60.00, 'stock_min' => 12.00, 'currency' => 'USD', 'sku' => 'SKU006', 'desc' => 'Description for Item 6', 'image_url' => 'http://example.com/image6.jpg', 'status' => 0, 'created_by' => 'admin', 'updated_by' => 'admin', 'created_at' => now(), 'updated_at' => now(), 'history_log' => 'Created by admin'],
            ['uuid' => Str::uuid(), 'name' => 'Item 7', 'category_id' => 7, 'subcategory_id' => 7, 'warehouse_id' => 7, 'rack_id' => 7, 'basic_price' => 700.00, 'sell_price' => 750.00, 'quantity' => 70, 'unit' => 'pcs', 'color' => 'Pink', 'stock' => 70.00, 'stock_min' => 14.00, 'currency' => 'USD', 'sku' => 'SKU007', 'desc' => 'Description for Item 7', 'image_url' => 'http://example.com/image7.jpg', 'status' => 0, 'created_by' => 'admin', 'updated_by' => 'admin', 'created_at' => now(), 'updated_at' => now(), 'history_log' => 'Created by admin'], ['uuid' => Str::uuid(), 'name' => 'Item 8', 'category_id' => 8, 'subcategory_id' => 8, 'warehouse_id' => 8, 'rack_id' => 8, 'basic_price' => 800.00, 'sell_price' => 850.00, 'quantity' => 80, 'unit' => 'pcs', 'color' => 'Brown', 'stock' => 80.00, 'stock_min' => 16.00, 'currency' => 'USD', 'sku' => 'SKU008', 'desc' => 'Description for Item 8', 'image_url' => 'http://example.com/image8.jpg', 'status' => 0, 'created_by' => 'admin', 'updated_by' => 'admin', 'created_at' => now(), 'updated_at' => now(), 'history_log' => 'Created by admin'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
