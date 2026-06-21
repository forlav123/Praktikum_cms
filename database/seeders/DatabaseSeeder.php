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
                'name'              => 'Admin GlowTech',
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
            [
                'category_id'  => $catId['laptop'],
                'name'         => 'ROG Zephyrus G14 Gaming Laptop',
                'slug'         => 'rog-zephyrus-g14-gaming-laptop',
                'description'  => 'ASUS ROG Zephyrus G14 adalah laptop gaming 14 inci paling kuat di dunia. Dibekali prosesor AMD Ryzen 9 terbaru dan NVIDIA GeForce RTX 4060, memberikan performa komputasi dan gaming luar biasa dalam bodi ultra-portable yang ringan dan stylish.',
                'price'        => 24999000,
                'stock'        => 5,
                'image'        => null,
                'is_active'    => true,
            ],
            [
                'category_id'  => $catId['laptop'],
                'name'         => 'MacBook Air M2 13-inch',
                'slug'         => 'macbook-air-m2-13-inch',
                'description'  => 'Didesain ulang sepenuhnya dengan chip M2 generasi berikutnya, MacBook Air terbaru ini luar biasa tipis dan menghadirkan kecepatan serta efisiensi daya yang luar biasa dalam bodi aluminium yang tangguh. Laptop ultra-portabel yang sangat andal.',
                'price'        => 16499000,
                'stock'        => 12,
                'image'        => null,
                'is_active'    => true,
            ],
            [
                'category_id'  => $catId['smartphone'],
                'name'         => 'iPhone 15 Pro Max 256GB',
                'slug'         => 'iphone-15-pro-max-256gb',
                'description'  => 'iPhone pertama dengan desain titanium sekelas kedirgantaraan, menggunakan chip A17 Pro revolusioner, sistem kamera internal tercanggih di iPhone, dan tombol Tindakan yang dapat disesuaikan.',
                'price'        => 22999000,
                'stock'        => 8,
                'image'        => null,
                'is_active'    => true,
            ],
            [
                'category_id'  => $catId['smartphone'],
                'name'         => 'Samsung Galaxy S24 Ultra',
                'slug'         => 'samsung-galaxy-s24-ultra',
                'description'  => 'Selamat datang di era Mobile AI. Dengan Galaxy S24 Ultra di genggaman Anda, tingkatkan kreativitas, produktivitas, dan kemungkinan baru di level yang belum pernah ada sebelumnya. Dibekali kamera 200MP dan S Pen ikonik.',
                'price'        => 20999000,
                'stock'        => 10,
                'image'        => null,
                'is_active'    => true,
            ],
            [
                'category_id'  => $catId['pakaian'],
                'name'         => 'Oversized Heavyweight Hoodie',
                'slug'         => 'oversized-heavyweight-hoodie',
                'description'  => 'Hoodie oversized premium dari bahan katun fleece 330gsm yang tebal namun sangat lembut dan nyaman. Memiliki potongan drop shoulder yang modern, jahitan rapi, dan saku kanguru di bagian depan.',
                'price'        => 349000,
                'stock'        => 25,
                'image'        => null,
                'is_active'    => true,
            ],
            [
                'category_id'  => $catId['pakaian'],
                'name'         => 'Slim Fit Chino Pants',
                'slug'         => 'slim-fit-chino-pants',
                'description'  => 'Celana chino slim fit dengan bahan katun twill berkualitas premium berkombinasi dengan spandex (stretch) untuk kebebasan bergerak. Cocok digunakan untuk gaya kasual harian maupun semi-formal.',
                'price'        => 279000,
                'stock'        => 18,
                'image'        => null,
                'is_active'    => true,
            ],
            [
                'category_id'  => $catId['aksesoris'],
                'name'         => 'Sony WH-1000XM5 ANC Headphones',
                'slug'         => 'sony-wh-1000xm5-anc-headphones',
                'description'  => 'Headphone nirkabel peredam bising terbaik dari Sony. WH-1000XM5 mendefinisikan ulang mendengarkan tanpa gangguan. Dilengkapi dengan dua prosesor pengontrol delapan mikrofon untuk performa peredaman luar biasa.',
                'price'        => 4999000,
                'stock'        => 6,
                'image'        => null,
                'is_active'    => true,
            ],
            [
                'category_id'  => $catId['aksesoris'],
                'name'         => 'Mechanical Keyboard TKL RGB',
                'slug'         => 'mechanical-keyboard-tkl-rgb',
                'description'  => 'Keyboard mekanikal layout Tenkeyless (TKL) dengan sakelar Gateron Brown yang tactile dan silent. Dilengkapi lampu latar RGB yang dapat diprogram penuh, bodi aluminium kokoh, dan tombol keycaps PBT dual-shot.',
                'price'        => 899000,
                'stock'        => 15,
                'image'        => null,
                'is_active'    => true,
            ],
            [
                'category_id'  => $catId['laptop'],
                'name'         => 'Asus Zenbook Duo OLED',
                'slug'         => 'asus-zenbook-duo-oled',
                'description'  => 'Laptop layar ganda 14 inci revolusioner dengan dua layar sentuh OLED 3K 120Hz. Hadir dengan keyboard Bluetooth yang dapat dilepas untuk produktivitas multi-screen yang belum pernah terjadi sebelumnya.',
                'price'        => 31999000,
                'stock'        => 3,
                'image'        => null,
                'is_active'    => true,
            ],
            [
                'category_id'  => $catId['aksesoris'],
                'name'         => 'Minimalist Leather Cardholder',
                'slug'         => 'minimalist-leather-cardholder',
                'description'  => 'Dompet kartu kulit sapi asli dengan desain minimalis ultra-tipis. Memiliki 4 slot kartu eksternal dan 1 kompartemen utama di tengah untuk uang tunai lipat. Proteksi RFID terintegrasi.',
                'price'        => 149000,
                'stock'        => 50,
                'image'        => null,
                'is_active'    => true,
            ],
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
