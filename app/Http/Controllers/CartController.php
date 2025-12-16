<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    protected $productController;

    public function __construct(ProductController $productController)
    {
        $this->productController = $productController;
    }

    public function index()
    {
        // Ambil keranjang mentah dari session
        $cart = Session::get('cart', []);

        $cartItems   = [];
        $totalQty    = 0;
        $totalPrice  = 0;

        foreach ($cart as $slug => $item) {
            // Ambil data produk lengkap dari ProductController
            $product = $this->productController->findBySlug($slug);

            // Kalau produk sudah tidak ada, skip saja
            if (!$product) {
                continue;
            }

            $qty   = (int)($item['qty'] ?? 1);
            $price = (int)($product['price'] ?? ($item['price'] ?? 0));

            // Gabungkan data dari session + produk (stok, nama, dll di-update dari produk)
            $cartItem = array_merge($item, [
                'slug'   => $slug,
                'name'   => $product['name']   ?? ($item['name']  ?? 'Produk'),
                'price'  => $price,
                'image'  => $product['image']  ?? ($item['image'] ?? null),
                'stock'  => $product['stock']  ?? null,   // ⬅️ stok diambil dari ProductController
                'seller' => $product['seller'] ?? ($item['seller'] ?? 'Penjual Kerajinan'),
                'rating' => $product['rating'] ?? ($item['rating'] ?? 5),
                'qty'    => $qty,
            ]);

            $cartItems[] = $cartItem;

            $totalQty    += $qty;
            $totalPrice  += $qty * $price;
        }

        return view('main.cart', compact('cartItems', 'totalQty', 'totalPrice'));
    }

    public function addToCart(Request $request)
    {
        $slug = $request->input('slug');
        $qty  = (int) $request->input('qty', 1);

        $product = $this->productController->findBySlug($slug);

        if (!$product) {
            return back()->withErrors(['msg' => 'Produk tidak ditemukan']);
        }

        $cart = Session::get('cart', []);

        if (isset($cart[$slug])) {
            $cart[$slug]['qty'] += $qty;
        } else {
            // Di sini stok boleh disimpan atau tidak, karena index() akan selalu override dari product
            $cart[$slug] = [
                'slug'   => $slug,
                'name'   => $product['name']   ?? 'Produk',
                'price'  => $product['price']  ?? 0,
                'image'  => $product['image']  ?? null,
                'qty'    => $qty,
            ];
        }

        Session::put('cart', $cart);

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request)
    {
        $slug = $request->input('slug');
        $qty  = (int) $request->input('qty');

        $cart = Session::get('cart', []);

        if (isset($cart[$slug])) {
            if ($qty > 0) {
                $cart[$slug]['qty'] = $qty;
            } else {
                unset($cart[$slug]);
            }
            Session::put('cart', $cart);
        }

        return back()->with('success', 'Keranjang diperbarui!');
    }

    public function remove($slug)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$slug])) {
            unset($cart[$slug]);
            Session::put('cart', $cart);
        }

        return back()->with('success', 'Produk dihapus dari keranjang!');
    }
}
