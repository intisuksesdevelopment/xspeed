<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdsSeeder extends Seeder
{
    public function run(): void
    {
        $ads = [
            // PROMO BANNERS (product page)
            [
                'type'        => 'promo',
                'title'      => null,
                'content'    => 'Gratis ongkir untuk pembelian di atas Rp 200.000',
                'code'       => 'FREEONGKIR',
                'link'       => null,
                'position'   => 'product_top',
                'is_active'  => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type'        => 'promo',
                'title'      => null,
                'content'    => 'Diskon 10% untuk semua produk oli mesin',
                'code'       => 'OLI10',
                'link'       => '/category/oli-mesin',
                'position'   => 'product_top',
                'is_active'  => true,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // ANNOUNCEMENT BANNER (product page bottom)
            [
                'type'        => 'announcement',
                'title'      => 'INFORMASI',
                'content'    => 'Kami hanya menjual sparepart ORIGINAL. Setiap produk dilengkapi garansi 30 hari.',
                'code'       => null,
                'link'       => null,
                'position'   => 'product_bottom',
                'is_active'  => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // ADS BANNER (product page - horizontal strip)
            [
                'type'        => 'banner',
                'title'      => 'Xspeed Service Centre',
                'content'    => 'Servis motor profesional — ganti oli, kampas rem, tune-up. Booking via WhatsApp!',
                'code'       => null,
                'link'       => 'https://wa.me/628123456789?text=Halo,%20saya%20mau%20booking%20servis',
                'position'   => 'product_ads',
                'is_active'  => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // ADS BANNER 2
            [
                'type'        => 'banner',
                'title'      => ' Grosir & Kooperasi',
                'content'    => 'Dapat harga khusus untuk pembelian partai besar. Hubungi kami sekarang!',
                'code'       => null,
                'link'       => 'https://wa.me/628123456789?text=Halo,%20saya%20mau%20tanya%20harga%20grosir',
                'position'   => 'product_ads',
                'is_active'  => true,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('ads')->insert($ads);
    }
}
