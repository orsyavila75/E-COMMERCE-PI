{{-- resources/views/landingPage/products.blade.php --}}
@extends('template.main-template')

@section('title', 'Katalog Produk - Kerajinan Nusantara')

@section('content')
@php 
    // boleh tetap, tapi Str sudah tidak dipakai lagi
    use Illuminate\Support\Str;
    $products = $products ?? collect([]);
    $q = $q ?? '';
@endphp

{{-- Hero Banner --}}
<section class="bg-gradient-to-r from-primary-800 to-primary-900 py-16 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 right-0 w-96 h-96 bg-white rounded-full blur-3xl"></div>
    </div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-2xl" data-aos="fade-right">
            <nav class="flex items-center gap-2 text-primary-300 text-sm mb-4">
                <a href="{{ url('/') }}" class="hover:text-white transition-colors">Beranda</a>
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                <span class="text-white">Produk</span>
            </nav>
            <h1 class="font-display text-4xl md:text-5xl font-bold text-white mb-4">
                Katalog Produk
            </h1>
            <p class="text-primary-200 text-lg">
                Temukan berbagai kerajinan tangan berkualitas dari pengrajin lokal Indonesia
            </p>
        </div>
    </div>
</section>

{{-- Main Content --}}
<section class="py-12 bg-primary-50 min-h-screen">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-8">
            
            {{-- Sidebar Filters --}}
            <aside class="lg:w-72 flex-shrink-0" data-aos="fade-right">
                <div class="bg-white rounded-2xl shadow-sm border border-primary-100 p-6 sticky top-24">
                    <h3 class="font-semibold text-primary-900 mb-4 flex items-center gap-2">
                        <i data-lucide="filter" class="w-5 h-5"></i>
                        Filter Produk
                    </h3>
                    
                    {{-- Search --}}
                    <form action="{{ route('products.page') }}" method="GET" class="mb-6">
                        <label class="text-sm text-primary-600 mb-2 block">Cari Produk</label>
                        <div class="relative">
                            <i data-lucide="search" class="w-4 h-4 text-primary-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Ketik nama produk..."
                                   class="w-full pl-10 pr-4 py-2.5 text-sm border border-primary-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                        </div>
                    </form>

                    {{-- Categories --}}
                    <div class="mb-6">
                        <label class="text-sm text-primary-600 mb-3 block">Kategori</label>
                        <div class="space-y-2">
                            @php
                                $categories = ['Anyaman', 'Ukiran', 'Batik', 'Rajutan'];
                                $currentKategori = request('kategori');
                            @endphp
                            <a href="{{ route('products.page') }}" 
                               class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ !$currentKategori ? 'bg-primary-100 text-primary-700' : 'hover:bg-primary-50 text-primary-600' }}">
                                <i data-lucide="grid-2x2" class="w-4 h-4"></i>
                                Semua Kategori
                            </a>
                            @foreach($categories as $cat)
                                <a href="{{ route('products.page', ['kategori' => strtolower($cat)]) }}" 
                                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ strtolower($currentKategori) === strtolower($cat) ? 'bg-primary-100 text-primary-700' : 'hover:bg-primary-50 text-primary-600' }}">
                                    @if($cat === 'Anyaman')
                                        <i data-lucide="grid-3x3" class="w-4 h-4"></i>
                                    @elseif($cat === 'Ukiran')
                                        <i data-lucide="trees" class="w-4 h-4"></i>
                                    @elseif($cat === 'Batik')
                                        <i data-lucide="shirt" class="w-4 h-4"></i>
                                    @else
                                        <i data-lucide="heart" class="w-4 h-4"></i>
                                    @endif
                                    {{ $cat }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                </div>
            </aside>

            {{-- Products Grid --}}
            <div class="flex-1">
                {{-- Search Results Info --}}
                @if(isset($q) && $q !== '')
                    <div class="bg-white rounded-xl p-4 mb-6 flex items-center justify-between" data-aos="fade-up">
                        <div class="flex items-center gap-3">
                            <i data-lucide="search" class="w-5 h-5 text-primary-500"></i>
                            <span class="text-primary-700">
                                Hasil pencarian untuk "<strong>{{ e($q) }}</strong>" — <span class="text-primary-500">{{ count($products) }} produk</span>
                            </span>
                        </div>
                        <a href="{{ route('products.page') }}" class="text-sm text-primary-600 hover:text-primary-800 flex items-center gap-1">
                            <i data-lucide="x" class="w-4 h-4"></i>
                            Reset
                        </a>
                    </div>
                @endif

                {{-- Sort & View Options --}}
                <div class="flex items-center justify-between mb-6" data-aos="fade-up">
                    <p class="text-primary-600">
                        Menampilkan <span class="font-semibold text-primary-900">{{ count($products) }}</span> produk
                    </p>
                    <div class="flex items-center gap-3">
                        <select class="px-4 py-2 text-sm border border-primary-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-primary-500/20">
                            <option>Urutkan: Terbaru</option>
                            <option>Harga: Rendah ke Tinggi</option>
                            <option>Harga: Tinggi ke Rendah</option>
                            <option>Rating Tertinggi</option>
                        </select>
                    </div>
                </div>

                {{-- Products --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @forelse ($products as $index => $product)
                        <div class="group" data-aos="fade-up" data-aos-delay="{{ ($index % 4) * 50 }}">
                            <div class="card-hover bg-white rounded-2xl overflow-hidden shadow-sm border border-primary-100">

                                {{-- BAGIAN GAMBAR → klik ke DETAIL --}}
                                <a href="{{ route('productdetail', $product['slug']) }}" class="relative overflow-hidden block">
                                    @php
                                        $imgPath = $product['image'] ?? '';
                                        $defaultImages = [
                                            'https://images.unsplash.com/photo-1590874103328-eac38a683ce7?w=400&h=400&fit=crop',
                                            'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=400&h=400&fit=crop',
                                            'https://images.unsplash.com/photo-1590736969955-71cc94901144?w=400&h=400&fit=crop',
                                            'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=400&h=400&fit=crop',
                                        ];
                                    @endphp
                                    <img src="{{ $imgPath ? asset('images/' . rawurlencode(basename($imgPath))) : $defaultImages[$index % 4] }}" 
                                         alt="{{ $product['name'] }}" 
                                         class="w-full h-52 object-cover group-hover:scale-110 transition-transform duration-500">
                                    
                                    <div class="absolute top-3 left-3">
                                        <span class="px-3 py-1 bg-white/90 backdrop-blur-sm text-primary-700 text-xs font-medium rounded-full">
                                            {{ $product['category'] ?? 'Kerajinan' }}
                                        </span>
                                    </div>
                                    
                                    <div class="absolute top-3 right-3 flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button type="button" class="w-9 h-9 bg-white rounded-full shadow-lg flex items-center justify-center text-primary-600 hover:text-red-500 transition-colors">
                                            <i data-lucide="heart" class="w-5 h-5"></i>
                                        </button>
                                        {{-- Tombol "lihat" juga ke DETAIL --}}
                                        <a href="{{ route('productdetail', $product['slug']) }}"
                                           class="w-9 h-9 bg-white rounded-full shadow-lg flex items-center justify-center text-primary-600 hover:text-primary-800 transition-colors">
                                            <i data-lucide="eye" class="w-5 h-5"></i>
                                        </a>
                                    </div>
                                </a>
                                
                                <div class="p-5">
                                    <div class="flex items-center gap-1 mb-2">
                                        @for($i = 0; $i < 5; $i++)
                                            <i data-lucide="star" class="w-4 h-4 {{ $i < ($product['rating'] ?? 4) ? 'fill-amber-400 text-amber-400' : 'text-gray-200' }}"></i>
                                        @endfor
                                        <span class="text-xs text-primary-500 ml-1">({{ $product['rating'] ?? 4 }}.0)</span>
                                    </div>
                                    
                                    {{-- NAMA PRODUK → juga link ke DETAIL --}}
                                    <a href="{{ route('productdetail', $product['slug']) }}"
                                       class="font-semibold text-primary-900 mb-2 group-hover:text-primary-600 transition-colors line-clamp-2 block">
                                        {{ $product['name'] }}
                                    </a>
                                    
                                    <div class="flex items-center justify-between">
                                        <span class="text-lg font-bold text-primary-700">
                                            Rp {{ number_format($product['price'], 0, ',', '.') }}
                                        </span>
                                        {{-- Tombol kecil ke DETAIL (ikon keranjang sementara) --}}
                                        <a href="{{ route('productdetail', $product['slug']) }}" 
                                           class="w-10 h-10 bg-primary-100 hover:bg-primary-600 text-primary-600 hover:text-white rounded-xl flex items-center justify-center transition-colors"
                                           title="Lihat detail produk">
                                            <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full">
                            <div class="bg-white rounded-2xl p-12 text-center" data-aos="fade-up">
                                <div class="w-20 h-20 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                    <i data-lucide="package-x" class="w-10 h-10 text-primary-400"></i>
                                </div>
                                <h3 class="text-xl font-semibold text-primary-900 mb-2">Produk Tidak Ditemukan</h3>
                                <p class="text-primary-500 mb-6">Coba ubah filter atau kata kunci pencarian Anda</p>
                                <a href="{{ route('products.page') }}" 
                                   class="inline-flex items-center gap-2 px-6 py-3 bg-primary-600 text-white font-medium rounded-xl hover:bg-primary-700 transition-colors">
                                    <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                                    Tampilkan Semua Produk
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination placeholder --}}
                @if(count($products) > 0)
                    <div class="flex justify-center mt-12" data-aos="fade-up">
                        <nav class="flex items-center gap-2">
                            <button class="w-10 h-10 flex items-center justify-center rounded-xl border border-primary-200 text-primary-600 hover:bg-primary-100 transition-colors">
                                <i data-lucide="chevron-left" class="w-5 h-5"></i>
                            </button>
                            <button class="w-10 h-10 flex items-center justify-center rounded-xl bg-primary-600 text-white font-medium">1</button>
                            <button class="w-10 h-10 flex items-center justify-center rounded-xl border border-primary-200 text-primary-600 hover:bg-primary-100 transition-colors">2</button>
                            <button class="w-10 h-10 flex items-center justify-center rounded-xl border border-primary-200 text-primary-600 hover:bg-primary-100 transition-colors">3</button>
                            <span class="px-2 text-primary-400">...</span>
                            <button class="w-10 h-10 flex items-center justify-center rounded-xl border border-primary-200 text-primary-600 hover:bg-primary-100 transition-colors">10</button>
                            <button class="w-10 h-10 flex items-center justify-center rounded-xl border border-primary-200 text-primary-600 hover:bg-primary-100 transition-colors">
                                <i data-lucide="chevron-right" class="w-5 h-5"></i>
                            </button>
                        </nav>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection
