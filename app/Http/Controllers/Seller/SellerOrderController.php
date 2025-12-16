<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;

class SellerOrderController extends Controller
{
    public function index()
    {
        $sellerId = auth()->id();

        $orders = \App\Models\Pemesanan::select(
                'pemesanan.id_pesan',
                'pemesanan.tanggal_pesan',
                'pemesanan.status_pemesanan',
                'customer.nama_customer',
                'produk.nama_produk',
                'produk.gambar',
                'detail_pemesanan.qty as jumlah',
                'detail_pemesanan.subtotal'
            )
            ->join('detail_pemesanan', 'pemesanan.id_pesan', '=', 'detail_pemesanan.id_pesan')
            ->join('produk', 'detail_pemesanan.id_produk', '=', 'produk.id_produk')
            ->join('customer', 'pemesanan.id_customer', '=', 'customer.id_customer')
            ->where('produk.id_seller', $sellerId)
            ->latest('pemesanan.tanggal_pesan')
            ->get();

        return view('main.seller-orders', compact('orders'));
    }
}
