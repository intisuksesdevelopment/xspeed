<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BankAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $storeAccounts = [
            [
                'uuid' => \Illuminate\Support\Str::uuid(),
                'bank_id' => 5, // BCA
                'owner_type' => 'store',
                'owner_id' => null,
                'account_number' => '1234567890',
                'account_name' => 'PT Xspeed Indonesia',
                'branch' => 'Jakarta Pusat',
                'description' => 'Rekening utama perusahaan',
                'status' => 0,
                'created_by' => 'system',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => \Illuminate\Support\Str::uuid(),
                'bank_id' => 2, // Mandiri
                'owner_type' => 'store',
                'owner_id' => null,
                'account_number' => '9876543210',
                'account_name' => 'PT Xspeed Indonesia',
                'branch' => 'Jakarta Selatan',
                'description' => 'Rekening operasional',
                'status' => 0,
                'created_by' => 'system',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => \Illuminate\Support\Str::uuid(),
                'bank_id' => 3, // BNI
                'owner_type' => 'store',
                'owner_id' => null,
                'account_number' => '5555666677',
                'account_name' => 'PT Xspeed Indonesia',
                'branch' => 'Jakarta Barat',
                'description' => 'Rekening cadangan',
                'status' => 0,
                'created_by' => 'system',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($storeAccounts as $account) {
            \App\Models\BankAccount::create($account);
        }
    }
}
