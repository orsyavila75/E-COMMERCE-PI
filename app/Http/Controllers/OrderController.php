<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * TAMPILKAN HALAMAN CHECKOUT BERDASARKAN ISI KERANJANG (SESSION)
     */
    public function checkoutFromCart()
    {
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart')
                ->with('error', 'Keranjang masih kosong, silakan pilih produk terlebih dahulu.');
        }

        // Ubah associative array jadi array biasa
        $checkoutItems = array_values($cart);

        $subtotal = 0;
        foreach ($checkoutItems as $item) {
            $subtotal += (int) $item['price'] * (int) $item['qty'];
        }

        // sementara ongkir flat
        $shipping = 25000;
        $discount = 0;
        $total    = $subtotal + $shipping - $discount;

        return view('main.checkout', [
            'checkoutItems' => $checkoutItems,
            'subtotal'      => $subtotal,
            'shipping'      => $shipping,
            'discount'      => $discount,
            'total'         => $total,
        ]);
    }

    /**
     * PROSES KETIKA TOMBOL "BAYAR SEKARANG" DIKLIK
     */
    public function storeFromCheckout(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:transfer_bank,e_wallet,cod',
            'bank_name'      => 'required_if:payment_method,transfer_bank|nullable|string',
            'e_wallet_name'  => 'required_if:payment_method,e_wallet|nullable|string',
        ], [
            'payment_method.required' => 'Silakan pilih metode pembayaran.',
        ]);

        $cart = Session::get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart')
                ->with('error', 'Keranjang kosong, tidak ada yang bisa di-checkout.');
        }

        $items    = array_values($cart);
        $subtotal = 0;
        foreach ($items as $item) {
            $subtotal += (int) $item['price'] * (int) $item['qty'];
        }

        $shipping = 25000;
        $discount = 0;
        $total    = $subtotal + $shipping - $discount;

        // generate kode pesanan
        $orderCode = 'ORD-' . date('YmdHis') . '-' . random_int(100, 999);

        // generate nomor VA dummy
        $paymentVa = '0022 ' . random_int(1000, 9999) . ' ' . random_int(1000, 9999);

        $order = Order::create([
            'user_id'        => Auth::id(),
            'code'           => $orderCode,
            'status'         => 'pending_payment',
            'payment_method' => $request->payment_method,
            'bank_name'      => $request->payment_method === 'transfer_bank' ? $request->bank_name : null,
            'e_wallet_name'  => $request->payment_method === 'e_wallet' ? $request->e_wallet_name : null,
            'payment_va'     => $paymentVa,
            'payment_owner'  => 'Kerajinan Nusantara',
            'subtotal'       => $subtotal,
            'shipping_cost'  => $shipping,
            'discount'       => $discount,
            'total'          => $total,
            'expires_at'     => Carbon::now()->addDay(), // 1 x 24 jam
        ]);

        // simpan item satu-satu
        foreach ($items as $item) {
            OrderItem::create([
                'order_id'      => $order->id,
                'product_slug'  => $item['slug'] ?? null,
                'product_name'  => $item['name'],
                'product_image' => $item['image'] ?? null,
                'seller_name'   => $item['seller'] ?? 'Penjual Kerajinan',
                'price'         => (int) $item['price'],
                'qty'           => (int) $item['qty'],
                'total'         => (int) $item['price'] * (int) $item['qty'],
            ]);
        }

        // kosongkan keranjang
        Session::forget('cart');

        // redirect ke halaman menunggu pembayaran
        return redirect()->route('payment.waiting', $order->id)
            ->with('success', 'Pesanan berhasil dibuat. Silakan lakukan pembayaran.');
    }

    /**
     * HALAMAN "MENUNGGU PEMBAYARAN"
     */
    public function showPayment(Order $order)
    {
        // biar user lain nggak bisa lihat pesanan kita
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('items');

        return view('main.payment-waiting', [
            'order' => $order,
        ]);
    }

    /**
     * UPLOAD BUKTI PEMBAYARAN
     */
    public function uploadProof(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'payment_proof' => 'required|image|max:2048', // max 2MB
        ], [
            'payment_proof.required' => 'Silakan upload bukti transfer.',
            'payment_proof.image'    => 'File harus berupa gambar (JPG/PNG).',
        ]);

        $path = $request->file('payment_proof')->store('payment_proofs', 'public');

        $order->payment_proof_path = $path;
        $order->status             = 'waiting_verification';
        $order->save();

        return back()->with('success', 'Bukti pembayaran berhasil diupload. Silakan tunggu verifikasi admin.');
    }
}
