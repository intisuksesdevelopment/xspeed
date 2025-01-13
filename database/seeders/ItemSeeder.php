<?php

namespace Database\Seeders;

use App\Models\Items;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $categories = [
        //     ['code' => 'ENGN', 'name' => 'Mesin', 'description' => 'Komponen utama yang menggerakkan sepeda motor.', 'image_url' => 'http://example.com/electronics.jpg', 'status' => 0, 'created_by' => 'admin', 'updated_by' => 'admin', 'created_at' => now(), 'updated_at' => now()],
        //     ['code' => 'GEAR', 'name' => 'Transmisi', 'description' => 'Sistem yang mentransfer tenaga dari mesin ke roda.', 'image_url' => 'http://example.com/furniture.jpg', 'status' => 0, 'created_by' => 'admin', 'updated_by' => 'admin', 'created_at' => now(), 'updated_at' => now()],
        //     ['code' => 'BRK', 'name' => 'Rem', 'description' => 'Sistem yang digunakan untuk memperlambat atau menghentikan motor.', 'image_url' => 'http://example.com/clothing.jpg', 'status' => 0, 'created_by' => 'admin', 'updated_by' => 'admin', 'created_at' => now(), 'updated_at' => now()],
        //     ['code' => 'SUS', 'name' => 'Suspensi', 'description' => 'Sistem yang menyerap guncangan dan menyediakan kenyamanan berkendara.', 'image_url' => 'http://example.com/books.jpg', 'status' => 0, 'created_by' => 'admin', 'updated_by' => 'admin', 'created_at' => now(), 'updated_at' => now()],
        //     ['code' => 'TIRE', 'name' => 'Roda dan Ban', 'description' => 'Komponen yang berhubungan langsung dengan jalan.', 'image_url' => 'http://example.com/toys.jpg', 'status' => 0, 'created_by' => 'admin', 'updated_by' => 'admin', 'created_at' => now(), 'updated_at' => now()],
        //     ['code' => 'ACCU', 'name' => 'Aki', 'description' => 'Sumber daya listrik untuk sepeda motor.', 'image_url' => 'http://example.com/sports.jpg', 'status' => 0, 'created_by' => 'admin', 'updated_by' => 'admin', 'created_at' => now(), 'updated_at' => now()],
        //     ['code' => 'EXAUST', 'name' => 'Knalpot', 'description' => 'Sistem yang mengeluarkan gas buang dari mesin.', 'image_url' => 'http://example.com/beauty.jpg', 'status' => 0, 'created_by' => 'admin', 'updated_by' => 'admin', 'created_at' => now(), 'updated_at' => now()],
        //     ['code' => 'FILTER', 'name' => 'Filter', 'description' => 'Komponen yang menyaring kotoran.', 'image_url' => 'http://example.com/automotive.jpg', 'status' => 0, 'created_by' => 'admin', 'updated_by' => 'admin', 'created_at' => now(), 'updated_at' => now()],
        //     ['code' => 'LAMP', 'name' => 'Lampu', 'description' => 'Sistem pencahayaan untuk keselamatan dan visibilitas.', 'image_url' => 'http://example.com/jewelry.jpg', 'status' => 0, 'created_by' => 'admin', 'updated_by' => 'admin', 'created_at' => now(), 'updated_at' => now()],
        //     ['code' => 'BODY', 'name' => 'Body Kit', 'description' => 'Bagian luar motor seperti fairing, spakbor,dan cover lainnya.', 'image_url' => 'http://example.com/groceries.jpg', 'status' => 0, 'created_by' => 'admin', 'updated_by' => 'admin', 'created_at' => now(), 'updated_at' => now()],
        // ];

        // foreach ($categories as $categorieData) {
        //     $category = new Categories();
        //     $category->fill($categorieData);
        //     $category->save();
        // }

        // $subcategories = [
        //     ['code'=>'BORE','category_id' => '39', 'name' => 'Silinder', 'description' => 'Komponen utama tempat pembakaran bahan bakar.', 'image_url' => 'http://example.com/electronics.jpg', 'status' => 0, 'created_by' => 'admin', 'updated_by' => 'admin', 'created_at' => now(), 'updated_at' => now()],
        //     ['code'=>'PIST','category_id' => '39', 'name' => 'Piston', 'description' => 'Komponen yang bergerak dalam silinder untuk menghasilkan tenaga.', 'image_url' => 'http://example.com/furniture.jpg', 'status' => 0, 'created_by' => 'admin', 'updated_by' => 'admin', 'created_at' => now(), 'updated_at' => now()],
        //     ['code'=>'KLP','category_id' => '39', 'name' => 'Klep', 'description' => 'Komponen yang mengatur aliran masuk dan keluar campuran udara-bahan bakar.', 'image_url' => 'http://example.com/clothing.jpg', 'status' => 0, 'created_by' => 'admin', 'updated_by' => 'admin', 'created_at' => now(), 'updated_at' => now()],
        //     ['code'=>'NOKEN','category_id' => '39', 'name' => 'Camshaft', 'description' => 'Komponen yang mengatur waktu buka-tutup katup.', 'image_url' => 'http://example.com/books.jpg', 'status' => 0, 'created_by' => 'admin', 'updated_by' => 'admin', 'created_at' => now(), 'updated_at' => now()],
        //             ];

        // foreach ($subcategories as $subcategorieData) {
        //     $subcategory = new SubCategories();
        //     $subcategory->fill($subcategorieData);
        //     $subcategory->save();
        // }
        // $warehouses = [
        //     ['name' => 'MainWarehouse', 'code' => 'WH001', 'description' => 'Mainwarehouseforelectronics', 'address' => '1234MainSt,Anytown,USA', 'phone' => '+1234567890', 'image_url' => 'http://example.com/warehouse1.jpg', 'status' => 0, 'created_by' => 'admin', 'updated_by' => 'admin', 'created_at' => now(), 'updated_at' => now()],
        //     ['name' => 'SecondaryWarehouse', 'code' => 'WH002', 'description' => 'Secondarywarehouseforfurniture', 'address' => '5678MarketSt,Anytown,USA', 'phone' => '+1234567891', 'image_url' => 'http://example.com/warehouse2.jpg', 'status' => 0, 'created_by' => 'admin', 'updated_by' => 'admin', 'created_at' => now(), 'updated_at' => now()],

        // ];

        // foreach ($warehouses as $warehouseData) {
        //     $warehouse = new Warehouses();
        //     $warehouse->fill($warehouseData);
        //     $warehouse->save();
        // }

        $items = [
            ['uuid' => Str::uuid(), 'name' => 'Item 1', 'category_id' => 10, 'subcategory_id' => 4, 'warehouse_id' => 1, 'rack_id' => 1, 'basic_price' => 100.00, 'sell_price' => 150.00, 'quantity' => 10, 'unit' => 'pcs', 'color' => 'Red', 'stock' => 10.00, 'stock_min' => 2.00, 'currency' => 'USD', 'sku' => 'SKU001', 'desc' => 'Description for Item 1', 'image_url' => 'http://example.com/image1.jpg', 'status' => 0, 'created_by' => 'admin', 'updated_by' => 'admin', 'created_at' => now(), 'updated_at' => now(), 'history_log' => 'Created by admin'],
            ['uuid' => Str::uuid(), 'name' => 'Item 2', 'category_id' => 10, 'subcategory_id' => 3, 'warehouse_id' => 2, 'rack_id' => 1, 'basic_price' => 200.00, 'sell_price' => 250.00, 'quantity' => 20, 'unit' => 'pcs', 'color' => 'Blue', 'stock' => 20.00, 'stock_min' => 4.00, 'currency' => 'USD', 'sku' => 'SKU002', 'desc' => 'Description for Item 2', 'image_url' => 'http://example.com/image2.jpg', 'status' => 0, 'created_by' => 'admin', 'updated_by' => 'admin', 'created_at' => now(), 'updated_at' => now(), 'history_log' => 'Created by admin'],
            ['uuid' => Str::uuid(), 'name' => 'Item 3', 'category_id' => 3, 'subcategory_id' => 3, 'warehouse_id' => 2, 'rack_id' => 1, 'basic_price' => 300.00, 'sell_price' => 350.00, 'quantity' => 30, 'unit' => 'pcs', 'color' => 'Green', 'stock' => 30.00, 'stock_min' => 6.00, 'currency' => 'USD', 'sku' => 'SKU003', 'desc' => 'Description for Item 3', 'image_url' => 'http://example.com/image3.jpg', 'status' => 0, 'created_by' => 'admin', 'updated_by' => 'admin', 'created_at' => now(), 'updated_at' => now(), 'history_log' => 'Created by admin'],
            ['uuid' => Str::uuid(), 'name' => 'Item 4', 'category_id' => 4, 'subcategory_id' => 4, 'warehouse_id' => 1, 'rack_id' => 1, 'basic_price' => 400.00, 'sell_price' => 450.00, 'quantity' => 40, 'unit' => 'pcs', 'color' => 'Yellow', 'stock' => 40.00, 'stock_min' => 8.00, 'currency' => 'USD', 'sku' => 'SKU004', 'desc' => 'Description for Item 4', 'image_url' => 'http://example.com/image4.jpg', 'status' => 0, 'created_by' => 'admin', 'updated_by' => 'admin', 'created_at' => now(), 'updated_at' => now(), 'history_log' => 'Created by admin'],
            ['uuid' => Str::uuid(), 'name' => 'Item 5', 'category_id' => 5, 'subcategory_id' => 5, 'warehouse_id' => 1, 'rack_id' => 1, 'basic_price' => 500.00, 'sell_price' => 550.00, 'quantity' => 50, 'unit' => 'pcs', 'color' => 'Orange', 'stock' => 50.00, 'stock_min' => 10.00, 'currency' => 'USD', 'sku' => 'SKU005', 'desc' => 'Description for Item 5', 'image_url' => 'http://example.com/image5.jpg', 'status' => 0, 'created_by' => 'admin', 'updated_by' => 'admin', 'created_at' => now(), 'updated_at' => now(), 'history_log' => 'Created by admin'],
            ['uuid' => Str::uuid(), 'name' => 'Item 6', 'category_id' => 6, 'subcategory_id' => 6, 'warehouse_id' => 1, 'rack_id' => 1, 'basic_price' => 600.00, 'sell_price' => 650.00, 'quantity' => 60, 'unit' => 'pcs', 'color' => 'Purple', 'stock' => 60.00, 'stock_min' => 12.00, 'currency' => 'USD', 'sku' => 'SKU006', 'desc' => 'Description for Item 6', 'image_url' => 'http://example.com/image6.jpg', 'status' => 0, 'created_by' => 'admin', 'updated_by' => 'admin', 'created_at' => now(), 'updated_at' => now(), 'history_log' => 'Created by admin'],
            ['uuid' => Str::uuid(), 'name' => 'Item 7', 'category_id' => 7, 'subcategory_id' => 6, 'warehouse_id' => 1, 'rack_id' => 1, 'basic_price' => 700.00, 'sell_price' => 750.00, 'quantity' => 70, 'unit' => 'pcs', 'color' => 'Pink', 'stock' => 70.00, 'stock_min' => 14.00, 'currency' => 'USD', 'sku' => 'SKU007', 'desc' => 'Description for Item 7', 'image_url' => 'http://example.com/image7.jpg', 'status' => 0, 'created_by' => 'admin', 'updated_by' => 'admin', 'created_at' => now(), 'updated_at' => now(), 'history_log' => 'Created by admin'],
            ['uuid' => Str::uuid(), 'name' => 'Item 8', 'category_id' => 8, 'subcategory_id' => null, 'warehouse_id' => 1, 'rack_id' => 1, 'basic_price' => 800.00, 'sell_price' => 850.00, 'quantity' => 80, 'unit' => 'pcs', 'color' => 'Brown', 'stock' => 80.00, 'stock_min' => 16.00, 'currency' => 'USD', 'sku' => 'SKU008', 'desc' => 'Description for Item 8', 'image_url' => 'http://example.com/image8.jpg', 'status' => 0, 'created_by' => 'admin', 'updated_by' => 'admin', 'created_at' => now(), 'updated_at' => now(), 'history_log' => 'Created by admin'],

            // Tambahkan data lainnya dengan pola yang sama
        ];

        foreach ($items as $itemData) {
            $item = new Items();
            $item->fill($itemData);
            $item->save();
        }
    }
}
