{{-- resources/views/main/seller-dashboard.blade.php --}}
@extends('template.seller-template')

@section('title', 'Dashboard Seller - Kerajinan Nusantara')
@section('page-title', 'Dashboard')

@section('content')

{{-- Welcome Banner --}}
<div class="bg-gradient-to-r from-primary-700 to-primary-900 rounded-2xl p-6 mb-8 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white rounded-full blur-3xl"></div>
    </div>
    <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">
                Halo, {{ auth()->user()->name ?? 'Seller' }}! 👋
            </h1>
            <p class="text-primary-200">
                Pantau penjualanmu dan kelola produk kerajinan lokal di sini.
            </p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('seller.report') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white/10 backdrop-blur-sm text-white font-medium rounded-xl hover:bg-white/20 transition-colors border border-white/20">
                <i data-lucide="bar-chart-3" class="w-4 h-4"></i>
                Lihat Laporan
            </a>
            <a href="{{ route('seller.add-product') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-primary-700 font-semibold rounded-xl hover:bg-primary-50 transition-colors shadow-lg">
                <i data-lucide="plus" class="w-4 h-4"></i>
                Tambah Produk
            </a>
        </div>
    </div>
</div>

{{-- Stats Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    {{-- Produk Aktif --}}
    <div class="bg-white rounded-2xl shadow-sm border border-primary-100 p-6 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                <i data-lucide="package" class="w-6 h-6 text-blue-600"></i>
            </div>
            <span class="text-xs font-medium text-green-600 bg-green-100 px-2 py-1 rounded-full">+12%</span>
        </div>
        <p class="text-3xl font-bold text-primary-900 mb-1">{{ $productsCount ?? 24 }}</p>
        <p class="text-sm text-primary-500">Produk Aktif</p>
    </div>

    {{-- Pesanan Hari Ini --}}
    <div class="bg-gradient-to-br from-primary-600 to-primary-800 rounded-2xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                <i data-lucide="shopping-bag" class="w-6 h-6"></i>
            </div>
            @if(($ordersTodayCount ?? 5) > 0)
                <span class="flex h-3 w-3 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                </span>
            @endif
        </div>
        <p class="text-3xl font-bold mb-1">{{ $ordersTodayCount ?? 5 }}</p>
        <p class="text-sm text-primary-200">Pesanan Hari Ini</p>
        <p class="text-xs text-primary-300 mt-2">{{ $ordersPendingCount ?? 3 }} perlu diproses</p>
    </div>

    {{-- Pendapatan Minggu Ini --}}
    <div class="bg-white rounded-2xl shadow-sm border border-primary-100 p-6 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                <i data-lucide="wallet" class="w-6 h-6 text-green-600"></i>
            </div>
            <span class="text-xs font-medium text-green-600 bg-green-100 px-2 py-1 rounded-full">+8%</span>
        </div>
        <p class="text-3xl font-bold text-primary-900 mb-1">Rp {{ number_format($weeklyRevenue ?? 2450000, 0, ',', '.') }}</p>
        <p class="text-sm text-primary-500">Pendapatan Minggu Ini</p>
    </div>

    {{-- Rating Toko --}}
    <div class="bg-white rounded-2xl shadow-sm border border-primary-100 p-6 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center">
                <i data-lucide="star" class="w-6 h-6 text-amber-600"></i>
            </div>
        </div>
        <div class="flex items-baseline gap-1 mb-1">
            <p class="text-3xl font-bold text-primary-900">4.9</p>
            <span class="text-primary-500">/5</span>
        </div>
        <p class="text-sm text-primary-500">Rating Toko</p>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-8">
    {{-- Recent Orders --}}
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-primary-100 overflow-hidden">
        <div class="p-6 border-b border-primary-100 flex items-center justify-between">
            <h2 class="font-semibold text-primary-900 flex items-center gap-2">
                <i data-lucide="clock" class="w-5 h-5 text-primary-600"></i>
                Pesanan Terbaru
            </h2>
            <a href="{{ route('seller.orders') }}" class="text-sm text-primary-600 hover:text-primary-800 font-medium">Lihat Semua</a>
        </div>
        <div class="divide-y divide-primary-100">
            @php
                $recentOrders = [
                    ['id' => 'ORD-001', 'customer' => 'Rina Maharani', 'product' => 'Tas Anyaman Pandan', 'total' => 180000, 'status' => 'Baru', 'time' => '5 menit lalu'],
                    ['id' => 'ORD-002', 'customer' => 'Budi Santoso', 'product' => 'Kain Batik Tulis', 'total' => 375000, 'status' => 'Diproses', 'time' => '1 jam lalu'],
                    ['id' => 'ORD-003', 'customer' => 'Dewi Lestari', 'product' => 'Patung Kayu Garuda', 'total' => 450000, 'status' => 'Dikirim', 'time' => '3 jam lalu'],
                    ['id' => 'ORD-004', 'customer' => 'Ahmad Yani', 'product' => 'Boneka Rajut', 'total' => 160000, 'status' => 'Selesai', 'time' => 'Kemarin'],
                ];
            @endphp
            @foreach($recentOrders as $order)
                <div class="p-4 hover:bg-primary-50 transition-colors">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center">
                                <i data-lucide="box" class="w-5 h-5 text-primary-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-primary-900">{{ $order['customer'] }}</p>
                                <p class="text-sm text-primary-500">{{ $order['product'] }} • {{ $order['id'] }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full 
                                {{ $order['status'] === 'Baru' ? 'bg-red-100 text-red-700' : '' }}
                                {{ $order['status'] === 'Diproses' ? 'bg-amber-100 text-amber-700' : '' }}
                                {{ $order['status'] === 'Dikirim' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $order['status'] === 'Selesai' ? 'bg-green-100 text-green-700' : '' }}">
                                {{ $order['status'] }}
                            </span>
                            <p class="text-sm font-semibold text-primary-900 mt-1">Rp {{ number_format($order['total'], 0, ',', '.') }}</p>
                            <p class="text-xs text-primary-400">{{ $order['time'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Quick Actions & Stats --}}
    <div class="space-y-6">
        {{-- Quick Actions --}}
        <div class="bg-white rounded-2xl shadow-sm border border-primary-100 p-6">
            <h2 class="font-semibold text-primary-900 mb-4">Aksi Cepat</h2>
            <div class="space-y-3">
                <a href="{{ route('seller.add-product') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-primary-50 transition-colors group">
                    <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center group-hover:bg-primary-200 transition-colors">
                        <i data-lucide="plus" class="w-5 h-5 text-primary-600"></i>
                    </div>
                    <span class="font-medium text-primary-900">Tambah Produk Baru</span>
                </a>
                <a href="{{ route('seller.orders') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-primary-50 transition-colors group">
                    <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center group-hover:bg-primary-200 transition-colors">
                        <i data-lucide="clipboard-list" class="w-5 h-5 text-primary-600"></i>
                    </div>
                    <span class="font-medium text-primary-900">Kelola Pesanan</span>
                </a>
                <a href="{{ route('chat') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-primary-50 transition-colors group">
                    <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center group-hover:bg-primary-200 transition-colors">
                        <i data-lucide="message-circle" class="w-5 h-5 text-primary-600"></i>
                    </div>
                    <span class="font-medium text-primary-900">Balas Chat</span>
                    <span class="ml-auto px-2 py-0.5 text-xs font-medium bg-red-100 text-red-600 rounded-full">2</span>
                </a>
            </div>
        </div>

        {{-- Top Products --}}
        <div class="bg-white rounded-2xl shadow-sm border border-primary-100 p-6">
            <h2 class="font-semibold text-primary-900 mb-4">Produk Terlaris</h2>
            <div class="space-y-4">
                @php
                    $topProducts = [
                        ['name' => 'Tas Anyaman Pandan', 'sold' => 45, 'image' => 'https://images.unsplash.com/photo-1590874103328-eac38a683ce7?w=100&h=100&fit=crop'],
                        ['name' => 'Kain Batik Tulis', 'sold' => 38, 'image' => 'https://images.unsplash.com/photo-1590736969955-71cc94901144?w=100&h=100&fit=crop'],
                        ['name' => 'Patung Kayu', 'sold' => 27, 'image' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=100&h=100&fit=crop'],
                    ];
                @endphp
                @foreach($topProducts as $index => $product)
                    <div class="flex items-center gap-3">
                        <span class="w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center text-xs font-bold text-primary-700">{{ $index + 1 }}</span>
                        <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="w-10 h-10 rounded-lg object-cover">
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-primary-900 truncate">{{ $product['name'] }}</p>
                            <p class="text-xs text-primary-500">{{ $product['sold'] }} terjual</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- Products Section --}}
<div class="mt-8 bg-white rounded-2xl shadow-sm border border-primary-100 overflow-hidden">
    <div class="p-6 border-b border-primary-100 flex items-center justify-between">
        <div>
            <h2 class="font-semibold text-primary-900 flex items-center gap-2">
                <i data-lucide="package" class="w-5 h-5 text-primary-600"></i>
                Produk Saya
            </h2>
            <p class="text-sm text-primary-500 mt-1">Daftar produk yang kamu jual</p>
        </div>
        <a href="{{ route('seller.add-product') }}" class="text-sm text-primary-600 hover:text-primary-800 font-medium flex items-center gap-1">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Tambah Produk
        </a>
    </div>

    @if(($products ?? collect())->count() === 0)
        {{-- Empty State --}}
        <div class="p-12 text-center">
            <div class="w-20 h-20 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i data-lucide="package-x" class="w-10 h-10 text-primary-400"></i>
            </div>
            <h3 class="text-xl font-semibold text-primary-900 mb-2">Belum Ada Produk</h3>
            <p class="text-primary-500 mb-6 max-w-md mx-auto">Toko kamu masih kosong. Yuk mulai upload produk kerajinan tanganmu agar bisa dilihat pembeli!</p>
            <a href="{{ route('seller.add-product') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-primary-600 text-white font-medium rounded-xl hover:bg-primary-700 transition-colors">
                <i data-lucide="plus" class="w-5 h-5"></i>
                Upload Produk Pertama
            </a>
        </div>
    @else
        {{-- Products Grid --}}
        <div class="p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="group bg-white rounded-2xl border border-primary-100 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                        <div class="h-48 bg-primary-50 relative overflow-hidden">
                            @if(!empty($product->gambar))
                                <img src="{{ asset('storage/'.$product->gambar) }}" alt="{{ $product->nama_produk }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <i data-lucide="image" class="w-12 h-12 text-primary-300"></i>
                                </div>
                            @endif
                            <div class="absolute top-3 right-3 flex items-center gap-1 bg-white/90 backdrop-blur-sm px-2 py-1 rounded-lg text-xs font-medium text-primary-700">
                                <i data-lucide="star" class="w-3 h-3 fill-amber-400 text-amber-400"></i>
                                {{ round($product->ulasan_avg_rating ?? 4.5, 1) }}
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-primary-900 mb-1 truncate">{{ $product->nama_produk }}</h3>
                            <p class="text-lg font-bold text-primary-700 mb-3">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                            <div class="flex items-center gap-2 text-xs text-primary-500 mb-4">
                                <span>Stok: {{ $product->stok ?? 0 }}</span>
                                <span>•</span>
                                <span>Terjual: {{ $product->terjual ?? 0 }}</span>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <a href="{{ route('seller.products.show', $product->id_produk) }}" class="py-2 text-center text-xs font-medium text-primary-600 border border-primary-200 rounded-lg hover:bg-primary-50 transition-colors">
                                    Edit
                                </a>
                                <form action="{{ route('seller.products.destroy', $product->id_produk) }}" method="POST" onsubmit="return confirm('Hapus produk ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full py-2 text-xs font-medium text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

@endsection 
