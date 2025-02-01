<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Create specific users
        User::factory()->create([
            'nik' => '202501110001',
            'username' => 'rezadio',
            'name' => 'Reza Dio Nugraha',
            'phone' => '+6285974046992',
            'email' => 'rezadionugraha@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::factory()->create([
            'nik' => '202501110001',
            'username' => 'ryanman',
            'name' => 'Ryan Mandhira',
            'phone' => '+6288574938475',
            'email' => 'ryanman@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}
