@extends('template.seller-template')

@section('title', 'Laporan Pendapatan - Kerajinan Nusantara')
@section('page-title', 'Laporan Pendapatan')

@section('content')

{{-- Header with Gradient --}}
<div class="relative mb-8 rounded-2xl overflow-hidden bg-gradient-to-r from-primary-800 to-primary-900 p-8 text-white shadow-xl">
    <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-primary-500/20 rounded-full blur-2xl"></div>
    
    <div class="relative z-10">
        <nav class="flex items-center gap-2 text-sm text-primary-200 mb-3">
            <a href="{{ route('seller.dashboard') }}" class="hover:text-white transition-colors flex items-center gap-1">
                <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Dashboard
            </a>
            <i data-lucide="chevron-right" class="w-4 h-4"></i>
            <span class="text-white font-medium">Laporan</span>
        </nav>
        <h1 class="text-3xl font-bold mb-2 tracking-tight">Laporan Pendapatan</h1>
        <p class="text-primary-100 text-lg max-w-2xl">Analisis performa penjualan dan pantau pertumbuhan bisnis Anda.</p>
    </div>
</div>

{{-- Stats Overview --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    {{-- Total Pendapatan --}}
    <div class="bg-white rounded-2xl shadow-sm border border-primary-100 p-6 hover:shadow-md transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-green-50 rounded-2xl flex items-center justify-center text-green-600 group-hover:scale-110 transition-transform">
                <i data-lucide="wallet" class="w-6 h-6"></i>
            </div>
            {{-- Placeholder for growth stat if needed later --}}
        </div>
        <p class="text-3xl font-bold text-primary-900 mb-1 tracking-tight">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        <p class="text-sm text-primary-500 font-medium">Total Pendapatan (Selesai)</p>
    </div>

    {{-- Total Pesanan --}}
    <div class="bg-white rounded-2xl shadow-sm border border-primary-100 p-6 hover:shadow-md transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 group-hover:scale-110 transition-transform">
                <i data-lucide="shopping-bag" class="w-6 h-6"></i>
            </div>
        </div>
        <p class="text-3xl font-bold text-primary-900 mb-1 tracking-tight">{{ $totalOrders }}</p>
        <p class="text-sm text-primary-500 font-medium">Total Pesanan</p>
    </div>

    {{-- Produk Terjual --}}
    <div class="bg-white rounded-2xl shadow-sm border border-primary-100 p-6 hover:shadow-md transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-600 group-hover:scale-110 transition-transform">
                <i data-lucide="package" class="w-6 h-6"></i>
            </div>
        </div>
        <p class="text-3xl font-bold text-primary-900 mb-1 tracking-tight">{{ $productsSold }}</p>
        <p class="text-sm text-primary-500 font-medium">Produk Terjual (Qty)</p>
    </div>

    {{-- Rata-rata --}}
    <div class="bg-white rounded-2xl shadow-sm border border-primary-100 p-6 hover:shadow-md transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-purple-50 rounded-2xl flex items-center justify-center text-purple-600 group-hover:scale-110 transition-transform">
                <i data-lucide="bar-chart-2" class="w-6 h-6"></i>
            </div>
        </div>
        <p class="text-3xl font-bold text-primary-900 mb-1 tracking-tight">Rp {{ number_format($averageOrderValue, 0, ',', '.') }}</p>
        <p class="text-sm text-primary-500 font-medium">Rata-rata per Pesanan</p>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-8">
    {{-- Main Content --}}
    <div class="lg:col-span-2 space-y-8">
        {{-- Chart Visualization --}}
        <div class="bg-white rounded-2xl shadow-sm border border-primary-100 overflow-hidden">
            <div class="p-6 border-b border-primary-50 bg-primary-50/30 flex items-center justify-between">
                <h2 class="font-bold text-primary-900 flex items-center gap-2 text-lg">
                    <i data-lucide="line-chart" class="w-5 h-5 text-primary-600"></i>
                    Grafik Pendapatan (7 Hari Terakhir)
                </h2>
            </div>
            <div class="p-8">
                <div class="flex items-end justify-between h-64 gap-4">
                    @php
                        $maxVal = max($chartData) > 0 ? max($chartData) : 1;
                    @endphp
                    @foreach($chartData as $index => $value)
                        <div class="flex-1 flex flex-col items-center gap-3 group">
                            <div class="relative w-full bg-primary-50 rounded-t-xl overflow-hidden h-full flex items-end">
                                <div class="w-full bg-gradient-to-t from-primary-600 to-primary-400 rounded-t-xl transition-all duration-500 group-hover:from-primary-700 group-hover:to-primary-500 relative" 
                                     style="height: {{ ($value / $maxVal) * 100 }}%">
                                    {{-- Tooltip --}}
                                    <div class="absolute -top-10 left-1/2 -translate-x-1/2 bg-primary-900 text-white text-xs font-bold px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-10">
                                        Rp {{ number_format($value, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                            <span class="text-xs font-medium text-primary-500 group-hover:text-primary-700 transition-colors">{{ $days[$index] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Transaction Table --}}
        <div class="bg-white rounded-2xl shadow-sm border border-primary-100 overflow-hidden">
            <div class="p-6 border-b border-primary-50 bg-primary-50/30 flex items-center justify-between">
                <h2 class="font-bold text-primary-900 flex items-center gap-2 text-lg">
                    <i data-lucide="history" class="w-5 h-5 text-primary-600"></i>
                    Riwayat Transaksi Terbaru
                </h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-primary-50/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-primary-600 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-primary-600 uppercase tracking-wider">Produk</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-primary-600 uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-primary-600 uppercase tracking-wider">Qty</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-primary-600 uppercase tracking-wider">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-primary-50">
                        @forelse($recentTransactions as $tx)
                            <tr class="hover:bg-primary-50/50 transition-colors">
                                <td class="px-6 py-4 text-sm font-medium text-primary-600">{{ \Carbon\Carbon::parse($tx->tanggal_pesan)->format('d M Y') }}</td>
                                <td class="px-6 py-4 text-sm font-bold text-primary-900">{{ $tx->nama_produk }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 text-xs font-bold bg-primary-100 text-primary-700 rounded-full border border-primary-200">{{ $tx->jenis_produk }}</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-primary-600 text-center font-medium">{{ $tx->qty }}</td>
                                <td class="px-6 py-4 text-sm font-bold text-primary-900 text-right">Rp {{ number_format($tx->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-primary-500">Belum ada transaksi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Sidebar --}}
    <div class="space-y-8">
        {{-- Filter --}}
        <div class="bg-white rounded-2xl shadow-sm border border-primary-100 p-6">
            <h3 class="font-bold text-primary-900 mb-6 flex items-center gap-2 text-lg">
                <i data-lucide="filter" class="w-5 h-5 text-primary-600"></i>
                Filter Laporan
            </h3>
            <form action="{{ route('seller.report') }}" method="GET" class="space-y-5">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-primary-700 mb-2">Mulai</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full px-4 py-3 border border-primary-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 bg-gray-50 focus:bg-white transition-colors text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-primary-700 mb-2">Akhir</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full px-4 py-3 border border-primary-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 bg-gray-50 focus:bg-white transition-colors text-sm">
                    </div>
                </div>
                <button type="submit" class="w-full py-3.5 bg-primary-600 text-white font-bold rounded-xl hover:bg-primary-700 transition-all shadow-lg shadow-primary-500/30 flex items-center justify-center gap-2 transform active:scale-[0.98]">
                    <i data-lucide="search" class="w-4 h-4"></i>
                    Terapkan Filter
                </button>
                @if(request('start_date') || request('end_date'))
                    <a href="{{ route('seller.report') }}" class="w-full py-3.5 bg-white border border-primary-200 text-primary-700 font-bold rounded-xl hover:bg-primary-50 transition-all flex items-center justify-center gap-2">
                        Reset Filter
                    </a>
                @endif
            </form>
        </div>

        {{-- Top Categories --}}
        <div class="bg-white rounded-2xl shadow-sm border border-primary-100 p-6">
            <h3 class="font-bold text-primary-900 mb-6 text-lg">Kategori Terlaris</h3>
            <div class="space-y-5">
                @php
                    $colors = ['bg-primary-500', 'bg-amber-500', 'bg-blue-500', 'bg-purple-500', 'bg-green-500'];
                    $i = 0;
                @endphp
                @forelse($categories as $cat)
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-bold text-primary-900">{{ $cat['name'] }}</span>
                            <span class="text-xs font-medium text-primary-500">{{ $cat['sales'] }} terjual</span>
                        </div>
                        <div class="w-full h-2.5 bg-primary-50 rounded-full overflow-hidden">
                            <div class="h-full {{ $colors[$i % count($colors)] }} rounded-full transition-all duration-1000" style="width: {{ $cat['percentage'] }}%"></div>
                        </div>
                    </div>
                    @php $i++; @endphp
                @empty
                    <p class="text-sm text-primary-500">Belum ada data kategori.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection
