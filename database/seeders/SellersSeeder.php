<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SellersSeeder extends Seeder
{
    /**
     * Seed data toko untuk user yang sudah upgrade menjadi Seller.
     * 
     * Sesuai deskripsi sistem:
     * - Seller bukan role terpisah sejak awal
     * - Seller berasal dari Customer yang upgrade dan diverifikasi Admin
     * - Tabel seller menyimpan data toko (nama_toko, deskripsi, dll)
     * - id_seller = id_user dari tabel users
     */
    public function run(): void
    {
        $sellers = [
            [
                'name' => 'Galeri Anyaman Nusantara',
                'email' => 'anyaman@nusantara.com',
                'password' => Hash::make('password'),
                'no_telepon' => '081234567890',
                'alamat' => 'Yogyakarta',
                'role' => 'seller',
                'nama_toko' => 'Galeri Anyaman Nusantara',
                'deskripsi_toko' => 'Toko kerajinan anyaman tradisional dari berbagai daerah Indonesia.',
                'alamat_pengiriman' => 'Yogyakarta',
                'kategori_produk' => 'Anyaman',
            ],
            [
                'name' => 'Ukir Kayu Bali',
                'email' => 'ukirbali@art.com',
                'password' => Hash::make('password'),
                'no_telepon' => '081345678901',
                'alamat' => 'Bali',
                'role' => 'seller',
                'nama_toko' => 'Ukir Kayu Bali',
                'deskripsi_toko' => 'Spesialis ukiran kayu khas Bali dengan sentuhan tradisional.',
                'alamat_pengiriman' => 'Bali',
                'kategori_produk' => 'Ukiran',
            ],
            [
                'name' => 'Batik Canting Ratu',
                'email' => 'batik@cantingratu.com',
                'password' => Hash::make('password'),
                'no_telepon' => '081456789012',
                'alamat' => 'Pekalongan',
                'role' => 'seller',
                'nama_toko' => 'Batik Canting Ratu',
                'deskripsi_toko' => 'Batik tulis dan cap asli Pekalongan dengan motif klasik dan modern.',
                'alamat_pengiriman' => 'Pekalongan',
                'kategori_produk' => 'Batik',
            ],
            [
                'name' => 'Rajut Cipta Karya',
                'email' => 'rajut@ciptakarya.com',
                'password' => Hash::make('password'),
                'no_telepon' => '081567890123',
                'alamat' => 'Bandung',
                'role' => 'seller',
                'nama_toko' => 'Rajut Cipta Karya',
                'deskripsi_toko' => 'Produk rajutan handmade berkualitas tinggi dari Bandung.',
                'alamat_pengiriman' => 'Bandung',
                'kategori_produk' => 'Rajutan',
            ],
        ];

        foreach ($sellers as $sellerData) {
            // 1. Create User
            DB::table('users')->upsert([
                [
                    'name' => $sellerData['name'],
                    'email' => $sellerData['email'],
                    'password' => $sellerData['password'],
                    'no_telepon' => $sellerData['no_telepon'],
                    'alamat' => $sellerData['alamat'],
                    'role' => $sellerData['role'],
                ]
            ], ['email'], ['name', 'password', 'no_telepon', 'alamat', 'role']);

            // 2. Get User ID
            $userId = DB::table('users')->where('email', $sellerData['email'])->value('id_user');

            // 3. Create Seller Profile
            if ($userId) {
                DB::table('seller')->upsert([
                    [
                        'id_seller' => $userId,
                        'nama' => $sellerData['name'],
                        'no_telepon' => $sellerData['no_telepon'],
                        'email' => $sellerData['email'],
                        'nama_toko' => $sellerData['nama_toko'],
                        'deskripsi_toko' => $sellerData['deskripsi_toko'],
                        'alamat_pengiriman' => $sellerData['alamat_pengiriman'],
                        'kategori_produk' => $sellerData['kategori_produk'],
                    ]
                ], ['id_seller'], ['nama', 'no_telepon', 'email', 'nama_toko', 'deskripsi_toko', 'alamat_pengiriman', 'kategori_produk']);
            }
        }
    }
}
