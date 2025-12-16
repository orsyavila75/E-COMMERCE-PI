@extends('template.main-template')

@section('title', 'E-Commerce Kerajinan Tangan Lokal - Produk Asli dari Pengrajin Indonesia')

@section('content')

{{-- Hero Section --}}
<section class="relative min-h-screen flex items-center justify-center overflow-hidden">
    {{-- Background Image with Overlay --}}
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1606722590583-6951b5ea92ad?q=80&w=2070&auto=format&fit=crop" 
             alt="Background Kerajinan" 
             class="w-full h-full object-cover object-center">
        <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-black/50 to-primary-900/90"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10 text-center" data-aos="fade-up">
        <h1 class="font-display text-5xl md:text-7xl lg:text-8xl font-bold text-white mb-8 leading-tight">
            E-Commerce <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-200 to-orange-200 italic">Kerajinan Tangan Lokal</span>
        </h1>
        
        <p class="text-lg md:text-xl text-white/80 max-w-2xl mx-auto mb-12 font-light leading-relaxed">
            Platform e-commerce terpercaya untuk kerajinan tangan lokal. 
            Belanja produk asli dari pengrajin terbaik Indonesia dengan kualitas terjamin.
        </p>

        <div class="flex flex-col sm:flex-row gap-5 justify-center items-center">
            <a href="{{ route('products.page') }}" class="group relative px-8 py-4 bg-white text-primary-900 font-semibold rounded-full overflow-hidden transition-all hover:shadow-[0_0_40px_rgba(255,255,255,0.3)]">
                <span class="relative z-10 flex items-center gap-2">
                    Jelajahi Koleksi
                    <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                </span>
            </a>
            <a href="#kategori" class="px-8 py-4 text-white border border-white/30 rounded-full font-medium hover:bg-white/10 transition-colors backdrop-blur-sm">
                Lihat Kategori
            </a>
        </div>
    </div>

    {{-- Scroll Indicator --}}
    <div class="absolute bottom-10 left-1/2 -translate-x-1/2 animate-bounce text-white/50">
        <i data-lucide="chevron-down" class="w-8 h-8"></i>
    </div>
</section>

{{-- Categories Section (Image Based) --}}
<section id="kategori" class="py-24 bg-primary-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="font-display text-4xl font-bold text-primary-900 mb-4">Kategori Pilihan</h2>
            <div class="w-24 h-1 bg-primary-300 mx-auto rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- Anyaman --}}
            <a href="{{ url('/products?kategori=anyaman') }}" class="group relative h-[400px] rounded-3xl overflow-hidden cursor-pointer" data-aos="fade-up" data-aos-delay="100">
                <img src="https://images.unsplash.com/photo-1590874103328-eac38a683ce7?w=600&h=800&fit=crop" alt="Anyaman" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-80 group-hover:opacity-90 transition-opacity"></div>
                <div class="absolute bottom-0 left-0 w-full p-8 translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                    <h3 class="font-display text-2xl font-bold text-white mb-2">Anyaman</h3>
                    <p class="text-white/80 text-sm opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100">
                        Keindahan rotan dan bambu yang dianyam dengan teliti.
                    </p>
                </div>
            </a>

            {{-- Ukiran --}}
            <a href="{{ url('/products?kategori=ukiran') }}" class="group relative h-[400px] rounded-3xl overflow-hidden cursor-pointer" data-aos="fade-up" data-aos-delay="200">
                <img src="https://images.unsplash.com/photo-1615891646274-12294154867b?w=600&h=800&fit=crop" alt="Ukiran" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-80 group-hover:opacity-90 transition-opacity"></div>
                <div class="absolute bottom-0 left-0 w-full p-8 translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                    <h3 class="font-display text-2xl font-bold text-white mb-2">Ukiran</h3>
                    <p class="text-white/80 text-sm opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100">
                        Seni pahat kayu dan batu yang bernilai tinggi.
                    </p>
                </div>
            </a>

            {{-- Batik --}}
            <a href="{{ url('/products?kategori=batik') }}" class="group relative h-[400px] rounded-3xl overflow-hidden cursor-pointer" data-aos="fade-up" data-aos-delay="300">
                <img src="https://images.unsplash.com/photo-1590736969955-71cc94901144?w=600&h=800&fit=crop" alt="Batik" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-80 group-hover:opacity-90 transition-opacity"></div>
                <div class="absolute bottom-0 left-0 w-full p-8 translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                    <h3 class="font-display text-2xl font-bold text-white mb-2">Batik</h3>
                    <p class="text-white/80 text-sm opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100">
                        Warisan dunia yang tertuang dalam kain.
                    </p>
                </div>
            </a>

            {{-- Rajutan --}}
            <a href="{{ url('/products?kategori=rajutan') }}" class="group relative h-[400px] rounded-3xl overflow-hidden cursor-pointer" data-aos="fade-up" data-aos-delay="400">
                <img src="https://images.unsplash.com/photo-1616699002805-0741e1e4a9c5?w=600&h=800&fit=crop" alt="Rajutan" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-80 group-hover:opacity-90 transition-opacity"></div>
                <div class="absolute bottom-0 left-0 w-full p-8 translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                    <h3 class="font-display text-2xl font-bold text-white mb-2">Rajutan</h3>
                    <p class="text-white/80 text-sm opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100">
                        Kehangatan dalam setiap helai benang.
                    </p>
                </div>
            </a>
        </div>
    </div>
</section>

{{-- Featured Products --}}
<section class="py-24 bg-white">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6" data-aos="fade-up">
            <div>
                <span class="text-primary-600 font-medium tracking-wider text-sm uppercase mb-2 block">Koleksi Terpopuler</span>
                <h2 class="font-display text-4xl font-bold text-primary-900">Produk Unggulan</h2>
            </div>
            <a href="{{ route('products.page') }}" class="group flex items-center gap-2 text-primary-800 font-medium hover:text-primary-600 transition-colors">
                Lihat Semua Produk
                <i data-lucide="arrow-right" class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @php
                $featuredProducts = [
                    ['name' => 'Tas Anyaman Pandan', 'price' => 180000, 'category' => 'Anyaman', 'rating' => 5, 'image' => 'https://images.unsplash.com/photo-1590874103328-eac38a683ce7?w=400&h=400&fit=crop'],
                    ['name' => 'Patung Kayu Garuda', 'price' => 450000, 'category' => 'Ukiran', 'rating' => 5, 'image' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=400&h=400&fit=crop'],
                    ['name' => 'Kain Batik Tulis', 'price' => 375000, 'category' => 'Batik', 'rating' => 5, 'image' => 'https://images.unsplash.com/photo-1590736969955-71cc94901144?w=400&h=400&fit=crop'],
                    ['name' => 'Boneka Rajut Amigurumi', 'price' => 160000, 'category' => 'Rajutan', 'rating' => 5, 'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=400&h=400&fit=crop'],
                ];
            @endphp

            @foreach($featuredProducts as $index => $product)
                <div class="group" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                    <div class="relative bg-primary-50 rounded-3xl overflow-hidden mb-4 aspect-square">
                        <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        
                        {{-- Hover Actions --}}
                        <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center gap-3">
                            <button class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-primary-900 hover:bg-primary-600 hover:text-white transition-all transform translate-y-4 group-hover:translate-y-0 duration-300 shadow-xl">
                                <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                            </button>
                            <a href="{{ route('products.page') }}" class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-primary-900 hover:bg-primary-600 hover:text-white transition-all transform translate-y-4 group-hover:translate-y-0 duration-300 delay-75 shadow-xl">
                                <i data-lucide="eye" class="w-5 h-5"></i>
                            </a>
                        </div>

                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 bg-white/90 backdrop-blur-md text-primary-900 text-xs font-bold rounded-full uppercase tracking-wider">
                                {{ $product['category'] }}
                            </span>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center gap-1 mb-2">
                            <i data-lucide="star" class="w-4 h-4 fill-amber-400 text-amber-400"></i>
                            <span class="text-sm font-medium text-primary-900">{{ $product['rating'] }}.0</span>
                        </div>
                        <h3 class="font-display text-xl font-bold text-primary-900 mb-1 group-hover:text-primary-600 transition-colors cursor-pointer">
                            {{ $product['name'] }}
                        </h3>
                        <p class="text-primary-600 font-medium">
                            Rp {{ number_format($product['price'], 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Artisan Spotlight --}}
<section class="py-24 bg-primary-900 relative overflow-hidden">
    {{-- Background Pattern --}}
    <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div data-aos="fade-right">
                <span class="text-primary-300 font-medium tracking-wider text-sm uppercase mb-4 block">Di Balik Layar</span>
                <h2 class="font-display text-4xl md:text-5xl font-bold text-white mb-6 leading-tight">
                    Bertemu dengan <br>
                    <span class="text-primary-400">Tangan-Tangan Terampil</span>
                </h2>
                <p class="text-primary-100 text-lg leading-relaxed mb-8">
                    Setiap produk di platform kami memiliki cerita unik. Dibuat dengan penuh dedikasi oleh pengrajin lokal berbakat yang telah mewarisi keahlian mereka secara turun-temurun. Dengan membeli produk kerajinan tangan kami, Anda turut mendukung pengrajin lokal dan mengembangkan ekonomi komunitas.
                </p>
                
                <div class="grid grid-cols-2 gap-8 mb-10">
                    <div>
                        <div class="text-4xl font-bold text-white mb-1">100+</div>
                        <div class="text-primary-400 text-sm">Pengrajin Terverifikasi</div>
                    </div>
                    <div>
                        <div class="text-4xl font-bold text-white mb-1">50+</div>
                        <div class="text-primary-400 text-sm">Desa Binaan</div>
                    </div>
                </div>

                <a href="{{ route('register') }}" class="inline-flex items-center gap-3 px-8 py-4 bg-primary-500 hover:bg-primary-400 text-white rounded-full font-semibold transition-colors">
                    Gabung Sebagai Seller
                    <i data-lucide="arrow-right" class="w-5 h-5"></i>
                </a>
            </div>

            <div class="relative" data-aos="fade-left">
                <div class="grid grid-cols-2 gap-4">
                    <img src="https://images.unsplash.com/photo-1528396518501-b53b655eb9b3?w=500&h=600&fit=crop" alt="Pengrajin 1" class="rounded-3xl object-cover w-full h-64 translate-y-8">
                    <img src="https://images.unsplash.com/photo-1506803862777-37823271b259?w=500&h=600&fit=crop" alt="Pengrajin 2" class="rounded-3xl object-cover w-full h-64">
                </div>
                {{-- Decorative Circle --}}
                <div class="absolute -z-10 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[120%] h-[120%] bg-primary-800/50 rounded-full blur-3xl"></div>
            </div>
        </div>
    </div>
</section>

{{-- Testimonials --}}
<section class="py-24 bg-primary-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="font-display text-4xl font-bold text-primary-900 mb-4">Apa Kata Mereka?</h2>
            <p class="text-primary-600 max-w-2xl mx-auto">Pengalaman belanja yang memuaskan dari pelanggan setia kami.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- Testi 1 --}}
            <div class="bg-white p-8 rounded-3xl shadow-sm hover:shadow-xl transition-shadow duration-300" data-aos="fade-up" data-aos-delay="100">
                <div class="flex gap-1 mb-6">
                    @for($i=0; $i<5; $i++) <i data-lucide="star" class="w-5 h-5 fill-amber-400 text-amber-400"></i> @endfor
                </div>
                <p class="text-primary-700 mb-6 leading-relaxed">
                    "Kualitas anyamannya luar biasa halus. Sangat bangga bisa memakai produk lokal dengan kualitas internasional. Pengiriman juga sangat aman."
                </p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center text-primary-700 font-bold text-lg">
                        S
                    </div>
                    <div>
                        <h4 class="font-bold text-primary-900">Siti Rahmawati</h4>
                        <p class="text-sm text-primary-500">Jakarta</p>
                    </div>
                </div>
            </div>

            {{-- Testi 2 --}}
            <div class="bg-white p-8 rounded-3xl shadow-sm hover:shadow-xl transition-shadow duration-300" data-aos="fade-up" data-aos-delay="200">
                <div class="flex gap-1 mb-6">
                    @for($i=0; $i<5; $i++) <i data-lucide="star" class="w-5 h-5 fill-amber-400 text-amber-400"></i> @endfor
                </div>
                <p class="text-primary-700 mb-6 leading-relaxed">
                    "Batik tulisnya asli dan motifnya sangat detail. Seller sangat ramah menjelaskan filosofi di balik motifnya. Recommended!"
                </p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center text-primary-700 font-bold text-lg">
                        B
                    </div>
                    <div>
                        <h4 class="font-bold text-primary-900">Budi Santoso</h4>
                        <p class="text-sm text-primary-500">Surabaya</p>
                    </div>
                </div>
            </div>

            {{-- Testi 3 --}}
            <div class="bg-white p-8 rounded-3xl shadow-sm hover:shadow-xl transition-shadow duration-300" data-aos="fade-up" data-aos-delay="300">
                <div class="flex gap-1 mb-6">
                    @for($i=0; $i<5; $i++) <i data-lucide="star" class="w-5 h-5 fill-amber-400 text-amber-400"></i> @endfor
                </div>
                <p class="text-primary-700 mb-6 leading-relaxed">
                    "Suka banget sama patung ukirannya. Detailnya hidup banget. Packing kayu super aman sampai di tujuan tanpa cacat sedikitpun."
                </p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center text-primary-700 font-bold text-lg">
                        D
                    </div>
                    <div>
                        <h4 class="font-bold text-primary-900">Dewi Lestari</h4>
                        <p class="text-sm text-primary-500">Bali</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CTA Section --}}
<section class="py-24 relative overflow-hidden">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1590736969955-71cc94901144?w=1200&auto=format&fit=crop" alt="Background" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-primary-900/90"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10 text-center" data-aos="zoom-in">
        <h2 class="font-display text-4xl md:text-5xl font-bold text-white mb-6">
            Mari Lestarikan Budaya Kita
        </h2>
        <p class="text-primary-100 text-lg max-w-2xl mx-auto mb-10">
            Dukung pengrajin lokal dan bangga menggunakan produk buatan Indonesia. 
            Mulai jelajahi koleksi terbaik kami sekarang.
        </p>
        <a href="{{ route('products.page') }}" class="inline-flex items-center gap-2 px-10 py-5 bg-white text-primary-900 font-bold rounded-full hover:bg-primary-50 transition-all transform hover:scale-105 shadow-2xl">
            Mulai Belanja
            <i data-lucide="shopping-bag" class="w-5 h-5"></i>
        </a>
    </div>
</section>

@endsection