<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SellerReportController extends Controller
{
    public function index(Request $request)
    {
        $sellerId = Auth::user()->id_user;

        // Base Query for Orders related to this seller
        // Note: Assuming 'detail_pemesanan' connects products and orders, and products belong to seller.
        $ordersQuery = DB::table('pemesanan')
            ->join('detail_pemesanan', 'pemesanan.id_pesan', '=', 'detail_pemesanan.id_pesan')
            ->join('produk', 'detail_pemesanan.id_produk', '=', 'produk.id_produk')
            ->where('produk.id_seller', $sellerId)
            ->select(
                'pemesanan.id_pesan',
                'pemesanan.tanggal_pesan',
                'pemesanan.status_pemesanan',
                'detail_pemesanan.qty',
                'detail_pemesanan.subtotal',
                'produk.nama_produk',
                'produk.jenis_produk'
            );

        // Filter Date Range
        if ($request->has('start_date') && $request->has('end_date')) {
            $ordersQuery->whereBetween('pemesanan.tanggal_pesan', [$request->start_date, $request->end_date]);
        }

        $allOrders = $ordersQuery->get();

        // 1. Total Pendapatan (Completed Orders)
        $totalRevenue = $allOrders->where('status_pemesanan', 'selesai')->sum('subtotal');

        // 2. Total Pesanan
        $totalOrders = $allOrders->unique('id_pesan')->count();

        // 3. Produk Terjual (Qty of completed/processed orders)
        $productsSold = $allOrders->whereIn('status_pemesanan', ['selesai', 'dikirim', 'diproses'])->sum('qty');

        // 4. Rata-rata per Pesanan
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        // 5. Chart Data (Last 7 Days Revenue)
        $chartData = [];
        $days = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $dayName = Carbon::now()->subDays($i)->format('D'); // Mon, Tue...
            
            $dailyRevenue = $allOrders->filter(function ($order) use ($date) {
                return Carbon::parse($order->tanggal_pesan)->format('Y-m-d') == $date && $order->status_pemesanan == 'selesai';
            })->sum('subtotal');

            $chartData[] = $dailyRevenue;
            $days[] = $dayName;
        }

        // 6. Recent Transactions (Pagination handled manually or via limit)
        $recentTransactions = $ordersQuery->orderBy('pemesanan.tanggal_pesan', 'desc')->limit(10)->get();

        // 7. Top Categories
        $categories = $allOrders->groupBy('jenis_produk')->map(function ($group) use ($productsSold) {
            $qty = $group->sum('qty');
            return [
                'name' => $group->first()->jenis_produk,
                'sales' => $qty,
                'percentage' => $productsSold > 0 ? round(($qty / $productsSold) * 100) : 0
            ];
        })->sortByDesc('sales')->take(5);

        return view('main.report-pendapatan', compact(
            'totalRevenue',
            'totalOrders',
            'productsSold',
            'averageOrderValue',
            'chartData',
            'days',
            'recentTransactions',
            'categories'
        ));
    }
}
