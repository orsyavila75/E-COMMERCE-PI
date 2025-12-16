<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Sumber data produk (sementara hardcoded).
     * Nanti kalau sudah pakai database tinggal ganti bagian ini.
     */
    public function getProducts(): array
    {
        $items = [
            [
                'name'     => 'Rak Buku',
                'price'    => 250000,
                'image'    => 'rak buku.jpg',
                'stock'    => 10,
                'category' => 'Anyaman',
            ],
            [
                'name'     => 'Gantungan',
                'price'    => 25000,
                'image'    => 'gantungan.jpg',
                'stock'    => 25,
                'category' => 'Anyaman',
            ],
            [
                'name'     => 'Vas Rotan',
                'price'    => 100000,
                'image'    => 'vas rotan.jpg',
                'stock'    => 15,
                'category' => 'Anyaman',
            ],
            [
                'name'     => 'Keranjang',
                'price'    => 150000,
                'image'    => 'keranjang.jpg',
                'stock'    => 12,
                'category' => 'Anyaman',
            ],
            [
                'name'     => 'Bingkai Foto',
                'price'    => 50000,
                'image'    => 'bingkai foto.jpg',
                'stock'    => 30,
                'category' => 'Ukiran',
            ],
            [
                'name'     => 'Storage',
                'price'    => 120000,
                'image'    => 'storage.jpg',
                'stock'    => 20,
                'category' => 'Anyaman',
            ],
            [
                'name'     => 'Craft Lamp',
                'price'    => 100000,
                'image'    => 'craft lamp.jpg',
                'stock'    => 18,
                'category' => 'Anyaman',
            ],
            [
                'name'     => 'Meja',
                'price'    => 200000,
                'image'    => 'meja.jpg',
                'stock'    => 8,
                'category' => 'Ukiran',
            ],
            [
                'name'     => 'Tas Rotan',
                'price'    => 90000,
                'image'    => 'tas rotan.jpg',
                'stock'    => 25,
                'category' => 'Anyaman',
            ],
            [
                'name'     => 'Kain Batik Tulis',
                'price'    => 375000,
                'image'    => 'batik.jpg',
                'stock'    => 5,
                'category' => 'Batik',
            ],
            [
                'name'     => 'Boneka Rajut',
                'price'    => 160000,
                'image'    => 'rajut.jpg',
                'stock'    => 10,
                'category' => 'Rajutan',
            ],
        ];

        // Tambahkan slug ke setiap produk
        return array_map(function ($p) {
            $p['slug'] = Str::slug($p['name']);
            return $p;
        }, $items);
    }

    /**
     * Halaman list produk (katalog)
     */
    public function index(Request $request)
    {
        $products = $this->getProducts();

        // Filter by Search Query
        $q = trim((string) $request->query('q', ''));
        if ($q !== '') {
            $filtered = [];

            foreach ($products as $p) {
                $name  = $p['name'] ?? '';
                $image = $p['image'] ?? '';

                // cek di nama atau image
                if (mb_stripos($name, $q) !== false || mb_stripos($image, $q) !== false) {
                    $filtered[] = $p;
                    continue;
                }

                // cek per kata di nama
                $words = preg_split('/\s+/', $name);
                foreach ($words as $w) {
                    if (mb_stripos($w, $q) !== false) {
                        $filtered[] = $p;
                        break;
                    }
                }
            }

            $products = $filtered;
        }

        // Filter by Category (?kategori=anyaman / ukiran / batik / rajutan)
        $kategori = trim((string) $request->query('kategori', ''));
        if ($kategori !== '') {
            $products = array_filter($products, function ($p) use ($kategori) {
                return strtolower($p['category'] ?? '') === strtolower($kategori);
            });

            // reindex array biar nggak pakai key lama
            $products = array_values($products);
        }

        return view('landingPage.products', compact('products', 'q'));
    }

    /**
     * Cari satu produk berdasarkan slug
     */
    public function findBySlug(string $slug): ?array
    {
        foreach ($this->getProducts() as $p) {
            if (($p['slug'] ?? Str::slug($p['name'])) === $slug) {
                return $p;
            }
        }

        return null;
    }

    /**
     * Halaman detail produk
     */
    public function show(string $slug)
    {
        $product = $this->findBySlug($slug);

        if (! $product) {
            abort(404, 'Produk tidak ditemukan');
        }

        return view('landingPage.productdetail', compact('product'));
    }
}
