<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddEcommerceLinksSeeder extends Seeder
{
    public function run(): void
    {
        $links = json_encode([
            [
                'platform' => 'Tokopedia',
                'url'      => 'https://tokopedia.com/xspeedshop',
            ],
            [
                'platform' => 'Shopee',
                'url'      => 'https://shopee.co.id/xspeedshop',
            ],
            [
                'platform' => 'TikTok',
                'url'      => 'https://tiktok.com/@xspeedshop',
            ],
            [
                'platform' => 'Lazada',
                'url'      => 'https://lazada.com/shop/xspeedshop',
            ],
        ]);

        // Update semua items yang link_url masih null atau kosong
        DB::table('items')
            ->whereNull('link_url')
            ->orWhere('link_url', '')
            ->orWhere('link_url', '[]')
            ->update(['link_url' => $links]);

        echo "Updated " . DB::table('items')->count() . " items with ecommerce links.\n";
    }
}
