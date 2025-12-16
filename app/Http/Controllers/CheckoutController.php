<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Tampilkan halaman checkout.
     * URL contoh: /checkout?slug=tas-kayu&qty=2
     */
    public function show(Request $request)
    {
        // Ambil slug & qty dari query
        $slug = $request->query('slug', '');
        $qty  = (int) $request->query('qty', 1);

        // Pastikan qty minimal 1
        if ($qty < 1) {
            $qty = 1;
        }

        // Cari produk berdasarkan slug
        $product = Product::where('slug', $slug)->first();

        if (! $product) {
            abort(404, 'Produk untuk checkout tidak ditemukan.');
        }

        // Hitung total harga
        $totalPrice = $product->price * $qty;

        // Kirim ke view main.checkout
        return view('main.checkout', [
            'product'    => $product,
            'qty'        => $qty,
            'totalPrice' => $totalPrice,
        ]);
    }

    /**
     * Proses submit checkout (sementara dummy).
     */
    public function submit(Request $request)
    {
        // Validasi
        $request->validate([
            'address' => 'required|string',
            'payment_method' => 'required|in:transfer_bank,e_wallet,cod',
            'bank_name' => 'required_if:payment_method,transfer_bank',
            'e_wallet_name' => 'required_if:payment_method,e_wallet',
            'promo_code' => 'nullable|string',
        ], [
            'bank_name.required_if' => 'Silakan pilih bank tujuan transfer.',
            'e_wallet_name.required_if' => 'Silakan pilih e-wallet yang digunakan.',
        ]);

        // Logika Promo Code (Dummy)
        $discount = 0;
        if ($request->filled('promo_code')) {
            if (strtoupper($request->promo_code) === 'DISKON10') {
                $discount = 10000; // Contoh diskon flat
            } else {
                return back()->withErrors(['promo_code' => 'Kode promo tidak valid.'])->withInput();
            }
        }

        // TODO: Simpan order ke database dengan detail pembayaran
        // $order->payment_method = $request->payment_method;
        // $order->payment_details = $request->bank_name ?? $request->e_wallet_name ?? null;
        // $order->discount = $discount;
        // ...

        $methodName = match($request->payment_method) {
            'transfer_bank' => 'Transfer Bank (' . strtoupper($request->bank_name) . ')',
            'e_wallet' => 'E-Wallet (' . ucfirst($request->e_wallet_name) . ')',
            'cod' => 'COD (Bayar di Tempat)',
            default => 'Lainnya'
        };

        return back()->with('success', "Pesanan berhasil dibuat! Metode: $methodName. " . ($discount > 0 ? "Diskon Rp " . number_format($discount) . " diterapkan." : ""));
    }
}
