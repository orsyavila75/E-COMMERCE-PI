@extends('template.main-template')

@section('title', 'Dashboard - Kerajinan Nusantara')

@section('content')

{{-- Hero Banner --}}
<section class="bg-gradient-to-r from-primary-800 to-primary-900 py-12 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 right-0 w-96 h-96 bg-white rounded-full blur-3xl"></div>
    </div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="flex items-center gap-6">
            <div class="w-20 h-20 bg-white/10 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                <span class="text-4xl font-bold text-white">{{ substr(Auth::user()->name ?? 'U', 0, 1) }}</span>
            </div>
            <div>
                <h1 class="font-display text-3xl font-bold text-white mb-1">
                    Halo, {{ Auth::user()->name ?? 'Customer' }}! 👋
                </h1>
                <p class="text-primary-200">Selamat datang di dashboard Anda</p>
            </div>
        </div>
    </div>
</section>

{{-- Main Content --}}
<section class="py-8 bg-primary-50 min-h-screen">
    <div class="container mx-auto px-4">
        
        {{-- Quick Stats --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            {{-- Pesanan --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-primary-100">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center">
                        <i data-lucide="shopping-bag" class="w-6 h-6 text-amber-600"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-primary-900">
                            {{ $totalOrders ?? 0 }}
                        </p>
                        <p class="text-sm text-primary-500">Pesanan</p>
                    </div>
                </div>
            </div>

            {{-- Selesai --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-primary-100">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <i data-lucide="package-check" class="w-6 h-6 text-green-600"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-primary-900">
                            {{ $totalFinished ?? 0 }}
                        </p>
                        <p class="text-sm text-primary-500">Selesai</p>
                    </div>
                </div>
            </div>

            {{-- Dikirim --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-primary-100">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <i data-lucide="truck" class="w-6 h-6 text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-primary-900">
                            {{ $totalShipped ?? 0 }}
                        </p>
                        <p class="text-sm text-primary-500">Dikirim</p>
                    </div>
                </div>
            </div>

            {{-- Wishlist --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-primary-100">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-rose-100 rounded-xl flex items-center justify-center">
                        <i data-lucide="heart" class="w-6 h-6 text-rose-600"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-primary-900">
                            {{ $wishlistCount ?? 0 }}
                        </p>
                        <p class="text-sm text-primary-500">Wishlist</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            {{-- Left Column --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Pesanan Terbaru --}}
                <div class="bg-white rounded-2xl shadow-sm border border-primary-100 overflow-hidden">
                    <div class="p-6 border-b border-primary-100 flex items-center justify-between">
                        <h2 class="font-semibold text-primary-900 flex items-center gap-2">
                            <i data-lucide="package" class="w-5 h-5 text-primary-600"></i>
                            Pesanan Terbaru
                        </h2>
                        @if(($totalOrders ?? 0) > 0)
                            <a href="#" class="text-sm text-primary-600 hover:text-primary-800 font-medium">Lihat Semua</a>
                        @endif
                    </div>

                    @if(($totalOrders ?? 0) === 0)
                        {{-- Belum ada pesanan --}}
                        <div class="p-6 text-sm text-primary-500">
                            Belum ada pesanan. Yuk mulai belanja di 
                            <a href="{{ route('products.page') }}" class="text-primary-600 font-semibold hover:text-primary-800">
                                halaman produk
                            </a>.
                        </div>
                    @else
                        {{-- Contoh tampilan pesanan (nanti bisa diganti data asli dari database) --}}
                        <div class="divide-y divide-primary-100">
                            @php
                                $orders = [
                                    ['id' => 'ORD-001', 'product' => 'Tas Anyaman Pandan', 'status' => 'Dikirim', 'date' => '28 Nov 2024', 'price' => 180000, 'color' => 'blue'],
                                    ['id' => 'ORD-002', 'product' => 'Kain Batik Tulis', 'status' => 'Diproses', 'date' => '27 Nov 2024', 'price' => 375000, 'color' => 'amber'],
                                    ['id' => 'ORD-003', 'product' => 'Patung Kayu Garuda', 'status' => 'Selesai', 'date' => '25 Nov 2024', 'price' => 450000, 'color' => 'green'],
                                ];
                            @endphp
                            @foreach($orders as $order)
                                <div class="p-4 hover:bg-primary-50 transition-colors">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-4">
                                            <div class="w-14 h-14 bg-primary-100 rounded-xl flex items-center justify-center">
                                                <i data-lucide="box" class="w-6 h-6 text-primary-600"></i>
                                            </div>
                                            <div>
                                                <p class="font-medium text-primary-900">{{ $order['product'] }}</p>
                                                <p class="text-sm text-primary-500">{{ $order['id'] }} • {{ $order['date'] }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <span class="inline-flex px-3 py-1 text-xs font-medium rounded-full 
                                                {{ $order['color'] === 'green' ? 'bg-green-100 text-green-700' : '' }}
                                                {{ $order['color'] === 'blue' ? 'bg-blue-100 text-blue-700' : '' }}
                                                {{ $order['color'] === 'amber' ? 'bg-amber-100 text-amber-700' : '' }}">
                                                {{ $order['status'] }}
                                            </span>
                                            <p class="text-sm font-semibold text-primary-900 mt-1">
                                                Rp {{ number_format($order['price'], 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Recommended Products --}}
                <div class="bg-white rounded-2xl shadow-sm border border-primary-100 overflow-hidden">
                    <div class="p-6 border-b border-primary-100 flex items-center justify-between">
                        <h2 class="font-semibold text-primary-900 flex items-center gap-2">
                            <i data-lucide="sparkles" class="w-5 h-5 text-primary-600"></i>
                            Rekomendasi Untuk Anda
                        </h2>
                        <a href="{{ route('products.page') }}" class="text-sm text-primary-600 hover:text-primary-800 font-medium">Lihat Semua</a>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @php
                                $products = [
                                    ['name' => 'Keranjang Rotan', 'price' => 95000, 'image' => 'https://images.unsplash.com/photo-1590874103328-eac38a683ce7?w=200&h=200&fit=crop'],
                                    ['name' => 'Topeng Barong', 'price' => 220000, 'image' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=200&h=200&fit=crop'],
                                    ['name' => 'Dompet Batik', 'price' => 125000, 'image' => 'https://images.unsplash.com/photo-1590736969955-71cc94901144?w=200&h=200&fit=crop'],
                                    ['name' => 'Boneka Rajut', 'price' => 160000, 'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=200&h=200&fit=crop'],
                                ];
                            @endphp
                            @foreach($products as $product)
                                <a href="#" class="group">
                                    <div class="aspect-square rounded-xl overflow-hidden mb-2">
                                        <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                    </div>
                                    <p class="text-sm font-medium text-primary-900 group-hover:text-primary-600 transition-colors truncate">{{ $product['name'] }}</p>
                                    <p class="text-sm font-bold text-primary-700">Rp {{ number_format($product['price'], 0, ',', '.') }}</p>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column --}}
            <div class="space-y-6">
                {{-- Quick Actions --}}
                <div class="bg-white rounded-2xl shadow-sm border border-primary-100 p-6">
                    <h2 class="font-semibold text-primary-900 mb-4">Menu Cepat</h2>
                    <div class="space-y-3">
                        <a href="{{ route('cart') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-primary-50 transition-colors group">
                            <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center group-hover:bg-primary-200 transition-colors">
                                <i data-lucide="shopping-cart" class="w-5 h-5 text-primary-600"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-primary-900">Keranjang Belanja</p>
                                <p class="text-xs text-primary-500">3 item</p>
                            </div>
                            <i data-lucide="chevron-right" class="w-5 h-5 text-primary-400"></i>
                        </a>
                        <a href="{{ route('profile') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-primary-50 transition-colors group">
                            <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center group-hover:bg-primary-200 transition-colors">
                                <i data-lucide="user" class="w-5 h-5 text-primary-600"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-primary-900">Profil Saya</p>
                                <p class="text-xs text-primary-500">Edit data diri</p>
                            </div>
                            <i data-lucide="chevron-right" class="w-5 h-5 text-primary-400"></i>
                        </a>
                        <a href="{{ route('chat') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-primary-50 transition-colors group">
                            <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center group-hover:bg-primary-200 transition-colors">
                                <i data-lucide="message-circle" class="w-5 h-5 text-primary-600"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-primary-900">Chat</p>
                                <p class="text-xs text-primary-500">2 pesan baru</p>
                            </div>
                            <i data-lucide="chevron-right" class="w-5 h-5 text-primary-400"></i>
                        </a>
                        <a href="{{ route('products.page') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-primary-50 transition-colors group">
                            <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center group-hover:bg-primary-200 transition-colors">
                                <i data-lucide="search" class="w-5 h-5 text-primary-600"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-primary-900">Jelajahi Produk</p>
                                <p class="text-xs text-primary-500">500+ produk</p>
                            </div>
                            <i data-lucide="chevron-right" class="w-5 h-5 text-primary-400"></i>
                        </a>
                    </div>
                </div>

                {{-- Upgrade to Seller --}}
                @if(Auth::user()->role === 'customer')
                <div class="bg-gradient-to-br from-primary-600 to-primary-800 rounded-2xl p-6 text-white">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mb-4">
                        <i data-lucide="store" class="w-6 h-6"></i>
                    </div>
                    <h3 class="font-semibold text-lg mb-2">Mulai Berjualan!</h3>
                    <p class="text-primary-100 text-sm mb-4">Upgrade akun Anda menjadi Seller dan mulai jual kerajinan tangan Anda.</p>
                    <a href="{{ route('seller.confirmation') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-primary-700 font-medium rounded-lg hover:bg-primary-50 transition-colors text-sm">
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        Daftar Jadi Seller
                    </a>
                </div>
                @endif

                {{-- Account Info --}}
                <div class="bg-white rounded-2xl shadow-sm border border-primary-100 p-6">
                    <h2 class="font-semibold text-primary-900 mb-4">Informasi Akun</h2>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between py-2 border-b border-primary-100">
                            <span class="text-sm text-primary-500">Email</span>
                            <span class="text-sm font-medium text-primary-900">{{ Auth::user()->email ?? 'user@example.com' }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-primary-100">
                            <span class="text-sm text-primary-500">No. Telepon</span>
                            <span class="text-sm font-medium text-primary-900">{{ Auth::user()->no_telepon ?? '-' }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2">
                            <span class="text-sm text-primary-500">Status</span>
                            <span class="inline-flex px-2 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full">Aktif</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
