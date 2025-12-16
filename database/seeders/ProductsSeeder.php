<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name'      => 'Rak Buku',
                'price'     => 250000,
                'image'     => 'rak buku.jpg',
                'stock'     => 10,
                'category'  => 'Anyaman',
                'description' => 'Rak buku anyaman yang cocok untuk menyimpan buku dan dekorasi ruangan.',
            ],
            [
                'name'      => 'Gantungan',
                'price'     => 25000,
                'image'     => 'gantungan.jpg',
                'stock'     => 25,
                'category'  => 'Anyaman',
                'description' => 'Gantungan serbaguna dari bahan anyaman yang kuat dan estetis.',
            ],
            [
                'name'      => 'Vas Rotan',
                'price'     => 100000,
                'image'     => 'vas rotan.jpg',
                'stock'     => 15,
                'category'  => 'Anyaman',
                'description' => 'Vas rotan handmade yang cocok untuk bunga kering maupun artificial.',
            ],
            [
                'name'      => 'Keranjang',
                'price'     => 150000,
                'image'     => 'keranjang.jpg',
                'stock'     => 12,
                'category'  => 'Anyaman',
                'description' => 'Keranjang anyaman multifungsi untuk penyimpanan di rumah Anda.',
            ],
            [
                'name'      => 'Bingkai Foto',
                'price'     => 50000,
                'image'     => 'bingkai foto.jpg',
                'stock'     => 30,
                'category'  => 'Ukiran',
                'description' => 'Bingkai foto kayu ukir dengan sentuhan tradisional.',
            ],
            [
                'name'      => 'Storage',
                'price'     => 120000,
                'image'     => 'storage.jpg',
                'stock'     => 20,
                'category'  => 'Anyaman',
                'description' => 'Tempat storage anyaman untuk menyimpan barang-barang kecil.',
            ],
            [
                'name'      => 'Craft Lamp',
                'price'     => 100000,
                'image'     => 'craft lamp.jpg',
                'stock'     => 18,
                'category'  => 'Anyaman',
                'description' => 'Lampu hias kerajinan tangan dengan nuansa hangat dan estetik.',
            ],
            [
                'name'      => 'Meja',
                'price'     => 200000,
                'image'     => 'meja.jpg',
                'stock'     => 8,
                'category'  => 'Ukiran',
                'description' => 'Meja kayu ukir khas nusantara yang kokoh dan elegan.',
            ],
            [
                'name'      => 'Tas Rotan',
                'price'     => 90000,
                'image'     => 'tas rotan.jpg',
                'stock'     => 25,
                'category'  => 'Anyaman',
                'description' => 'Tas rotan cantik yang cocok untuk hangout atau ke pantai.',
            ],
            [
                'name'      => 'Kain Batik Tulis',
                'price'     => 375000,
                'image'     => 'batik.jpg',
                'stock'     => 5,
                'category'  => 'Batik',
                'description' => 'Kain batik tulis berkualitas dengan motif khas tradisional.',
            ],
            [
                'name'      => 'Boneka Rajut',
                'price'     => 160000,
                'image'     => 'rajut.jpg',
                'stock'     => 10,
                'category'  => 'Rajutan',
                'description' => 'Boneka rajut amigurumi lucu, cocok sebagai hadiah.',
            ],
        ];

        foreach ($products as $data) {
            Product::updateOrCreate(
                ['slug' => Str::slug($data['name'])], // cari berdasarkan slug
                [
                    'name'        => $data['name'],
                    'slug'        => Str::slug($data['name']),
                    'price'       => $data['price'],
                    'stock'       => $data['stock'],
                    'category'    => $data['category'],
                    'image'       => $data['image'],
                    'description' => $data['description'],
                ]
            );
        }
    }
}
