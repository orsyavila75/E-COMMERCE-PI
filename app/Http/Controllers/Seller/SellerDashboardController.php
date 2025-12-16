<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Pemesanan;
use Carbon\Carbon;

class SellerDashboardController extends Controller
{
    public function index()
    {
        $sellerId = auth()->id(); // ini id_user dari users

        // ambil produk milik seller (di tabel produk FK-nya id_seller)
        $products = Produk::where('id_seller', $sellerId)
            ->withAvg('ulasan', 'rating')
            ->withCount('ulasan')
            ->latest('id_produk')
            ->get();

        $productsCount = $products->count();

        // hitung pesanan hari ini (filter lewat produk seller)
        $ordersTodayCount = Pemesanan::join('detail_pemesanan', 'pemesanan.id_pesan', '=', 'detail_pemesanan.id_pesan')
            ->join('produk', 'detail_pemesanan.id_produk', '=', 'produk.id_produk')
            ->where('produk.id_seller', $sellerId)
            ->whereDate('pemesanan.tanggal_pesan', Carbon::today())
            ->distinct()
            ->count('pemesanan.id_pesan');

        // pesanan pending seller
        $ordersPendingCount = Pemesanan::join('detail_pemesanan', 'pemesanan.id_pesan', '=', 'detail_pemesanan.id_pesan')
            ->join('produk', 'detail_pemesanan.id_produk', '=', 'produk.id_produk')
            ->where('produk.id_seller', $sellerId)
            ->whereIn('pemesanan.status_pemesanan', ['baru','diproses','dikirim'])
            ->distinct()
            ->count('pemesanan.id_pesan');

        // revenue minggu ini (hanya status selesai)
        $weeklyRevenue = Pemesanan::join('detail_pemesanan', 'pemesanan.id_pesan', '=', 'detail_pemesanan.id_pesan')
            ->join('produk', 'detail_pemesanan.id_produk', '=', 'produk.id_produk')
            ->where('produk.id_seller', $sellerId)
            ->where('pemesanan.status_pemesanan', 'selesai')
            ->whereBetween('pemesanan.tanggal_pesan', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])
            ->sum('detail_pemesanan.subtotal'); 
            // ✅ lebih akurat daripada total_harga karena total_harga milik semua seller

        return view('main.seller-dashboard', compact(
            'products',
            'productsCount',
            'ordersTodayCount',
            'ordersPendingCount',
            'weeklyRevenue'
        ));
    }
}
