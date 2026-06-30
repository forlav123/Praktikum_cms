<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // === USERS ===
        DB::table('users')->updateOrInsert(
            ['email' => 'forlavhadiman@gmail.com'],
            [
                'name'              => 'Admin Toko Maju Jaya',
                'email'             => 'forlavhadiman@gmail.com',
                'password'          => Hash::make('password123'),
                'email_verified_at' => now(),
                'created_at'        => now(),
                'updated_at'        => now(),
            ]
        );

        // === CATEGORIES ===
        $categories = [
            ['name' => 'Laptop',      'slug' => 'laptop'],
            ['name' => 'Smartphone',  'slug' => 'smartphone'],
            ['name' => 'Pakaian',     'slug' => 'pakaian'],
            ['name' => 'Aksesoris',   'slug' => 'aksesoris'],
        ];

        foreach ($categories as $cat) {
            DB::table('categories')->updateOrInsert(
                ['slug' => $cat['slug']],
                array_merge($cat, ['created_at' => now(), 'updated_at' => now()])
            );
        }

        $catId = DB::table('categories')->pluck('id', 'slug');

        // === PRODUCTS ===
        $products = [
            // Kosong, produk akan ditambahkan secara manual melalui Dashboard
        ];

        // Hapus produk lama yang tidak sesuai, insert/update yang baru
        foreach ($products as $prod) {
            DB::table('products')->updateOrInsert(
                ['slug' => $prod['slug']],
                array_merge($prod, ['created_at' => now(), 'updated_at' => now()])
            );
        }

        $this->command->info('✅ Seeder selesai: ' . count($products) . ' produk, ' . count($categories) . ' kategori berhasil di-seed!');
    }
}
