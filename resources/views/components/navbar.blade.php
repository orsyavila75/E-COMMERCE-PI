{{-- Modern Navbar Component --}}
<nav class="glass sticky top-0 z-50 border-b border-primary-100" x-data="{ mobileMenu: false, profileMenu: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">

            {{-- Logo & Brand --}}
            <div class="flex items-center gap-12">
                <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 bg-gradient-to-br from-primary-600 to-primary-800 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-primary-300 transition-shadow">
                        <i data-lucide="leaf" class="w-6 h-6 text-white"></i>
                    </div>
                    <span class="font-display text-xl font-bold text-primary-900 hidden sm:block">
                        Kerajinan<span class="text-primary-600">Tangan</span>
                    </span>
                </a>

                {{-- Desktop Navigation --}}
                <div class="hidden lg:flex items-center gap-8">
                    <a href="{{ url('/') }}" class="text-primary-700 font-medium hover:text-primary-900 transition-colors relative group">
                        Beranda
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary-600 group-hover:w-full transition-all duration-300"></span>
                    </a>
                    <a href="{{ url('/products') }}" class="text-primary-700 font-medium hover:text-primary-900 transition-colors relative group">
                        Produk
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary-600 group-hover:w-full transition-all duration-300"></span>
                    </a>
                    <div class="relative group">
                        <button class="text-primary-700 font-medium hover:text-primary-900 transition-colors flex items-center gap-1">
                            Kategori
                            <i data-lucide="chevron-down" class="w-4 h-4 group-hover:rotate-180 transition-transform"></i>
                        </button>
                        {{-- Dropdown --}}
                        <div class="absolute top-full left-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-primary-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform group-hover:translate-y-0 translate-y-2">
                            <div class="py-2">
                                <a href="{{ url('/products?kategori=anyaman') }}" class="flex items-center gap-3 px-4 py-2.5 text-primary-700 hover:bg-primary-50 hover:text-primary-900 transition-colors">
                                    <i data-lucide="grid-3x3" class="w-4 h-4"></i>
                                    Anyaman
                                </a>
                                <a href="{{ url('/products?kategori=ukiran') }}" class="flex items-center gap-3 px-4 py-2.5 text-primary-700 hover:bg-primary-50 hover:text-primary-900 transition-colors">
                                    <i data-lucide="trees" class="w-4 h-4"></i>
                                    Ukiran
                                </a>
                                <a href="{{ url('/products?kategori=batik') }}" class="flex items-center gap-3 px-4 py-2.5 text-primary-700 hover:bg-primary-50 hover:text-primary-900 transition-colors">
                                    <i data-lucide="shirt" class="w-4 h-4"></i>
                                    Batik
                                </a>
                                <a href="{{ url('/products?kategori=rajutan') }}" class="flex items-center gap-3 px-4 py-2.5 text-primary-700 hover:bg-primary-50 hover:text-primary-900 transition-colors">
                                    <i data-lucide="heart" class="w-4 h-4"></i>
                                    Rajutan
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Section --}}
            <div class="flex items-center gap-3">

                {{-- Search Bar --}}
                <form action="{{ route('products.page') }}" method="GET" class="hidden md:block relative">
                    <i data-lucide="search" class="w-5 h-5 text-primary-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                    <input
                        type="text"
                        name="q"
                        value="{{ request()->get('q', '') }}"
                        placeholder="Cari produk..."
                        class="w-64 pl-10 pr-4 py-2.5 text-sm bg-primary-50 text-primary-900 placeholder:text-primary-400
                               border border-primary-200 rounded-xl
                               focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500
                               transition-all duration-200"
                    />
                </form>

                {{-- Cart Icon --}}
                <a href="{{ route('cart') }}" class="relative p-2.5 text-primary-600 hover:text-primary-900 hover:bg-primary-100 rounded-xl transition-colors">
                    <i data-lucide="shopping-bag" class="w-6 h-6"></i>
                    @php
                        $cartCount = 0;
                        if(session('cart')) {
                            foreach(session('cart') as $item) {
                                $cartCount += $item['qty'];
                            }
                        }
                    @endphp
                    <span class="absolute -top-1 -right-1 w-5 h-5 bg-primary-600 text-white text-xs font-bold rounded-full flex items-center justify-center">{{ $cartCount }}</span>
                </a>

                {{-- Chat Icon --}}
                <a href="{{ route('chat') }}" class="p-2.5 text-primary-600 hover:text-primary-900 hover:bg-primary-100 rounded-xl transition-colors">
                    <i data-lucide="message-circle" class="w-6 h-6"></i>
                </a>

                {{-- Profile / Auth --}}
                @if(Auth::guard('admin')->check() || Auth::check())
                    {{-- ADA YANG LOGIN: admin atau user biasa --}}
                    <div class="relative" x-data="{ open: false }">
                        @php
                            if (Auth::guard('admin')->check()) {
                                $displayName = Auth::guard('admin')->user()->nama_admin ?? Auth::guard('admin')->user()->email;
                            } else {
                                $displayName = Auth::user()->name;
                            }
                        @endphp

                        <button @click="open = !open" class="flex items-center gap-2 p-1.5 hover:bg-primary-100 rounded-xl transition-colors">
                            <div class="w-9 h-9 bg-gradient-to-br from-primary-500 to-primary-700 rounded-xl flex items-center justify-center text-white font-semibold text-sm">
                                {{ strtoupper(substr($displayName, 0, 1)) }}
                            </div>
                            <i data-lucide="chevron-down" class="w-4 h-4 text-primary-600"></i>
                        </button>
                        
                        {{-- Dropdown Menu --}}
                        <div x-show="open" @click.away="open = false" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-primary-100 py-2">
                            
                            {{-- Header identitas --}}
                            <div class="px-4 py-3 border-b border-primary-100">
                                @if(Auth::guard('admin')->check())
                                    <p class="text-sm font-semibold text-primary-900">
                                        {{ Auth::guard('admin')->user()->nama_admin ?? 'Admin' }}
                                    </p>
                                    <p class="text-xs text-primary-500">
                                        {{ Auth::guard('admin')->user()->email }}
                                    </p>
                                @else
                                    <p class="text-sm font-semibold text-primary-900">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-primary-500">{{ Auth::user()->email }}</p>
                                @endif
                            </div>
                            
                            {{-- DASHBOARD LINK --}}
                            @if(Auth::guard('admin')->check())
                                {{-- Admin guard --}}
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-primary-700 hover:bg-primary-50 transition-colors">
                                    <i data-lucide="shield" class="w-4 h-4"></i>
                                    Dashboard Admin
                                </a>
                            @else
                                {{-- User biasa (guard web) --}}
                                @if(Auth::user()->role === 'seller')
                                    <a href="{{ route('seller.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-primary-700 hover:bg-primary-50 transition-colors">
                                        <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                                        Dashboard Seller
                                    </a>
                                @else
                                    <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-primary-700 hover:bg-primary-50 transition-colors">
                                        <i data-lucide="user" class="w-4 h-4"></i>
                                        Dashboard
                                    </a>
                                @endif
                            @endif
                            
                            {{-- PENGATURAN --}}
                            @if(!Auth::guard('admin')->check())
                                {{-- pengaturan hanya untuk user biasa, kalau admin mau bisa diarahkan ke halaman lain --}}
                                <a href="{{ route('profile') }}" class="flex items-center gap-3 px-4 py-2.5 text-primary-700 hover:bg-primary-50 transition-colors">
                                    <i data-lucide="settings" class="w-4 h-4"></i>
                                    Pengaturan
                                </a>
                            @endif
                            
                            {{-- LOGOUT --}}
                            <div class="border-t border-primary-100 mt-2 pt-2">
                                @if(Auth::guard('admin')->check())
                                    {{-- Logout ADMIN --}}
                                    <form method="POST" action="{{ route('admin.logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-red-600 hover:bg-red-50 transition-colors">
                                            <i data-lucide="log-out" class="w-4 h-4"></i>
                                            Logout
                                        </button>
                                    </form>
                                @else
                                    {{-- Logout USER BIASA --}}
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-red-600 hover:bg-red-50 transition-colors">
                                            <i data-lucide="log-out" class="w-4 h-4"></i>
                                            Logout
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @else
                    {{-- TIDAK ADA YANG LOGIN: tombol Login / Daftar --}}
                    <a href="{{ route('login') }}" class="hidden sm:flex items-center gap-2 px-4 py-2.5 text-primary-700 font-medium hover:text-primary-900 transition-colors">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="btn-shine px-5 py-2.5 bg-gradient-to-r from-primary-600 to-primary-700 text-white font-medium rounded-xl hover:from-primary-700 hover:to-primary-800 transition-all shadow-lg shadow-primary-500/25">
                        Daftar
                    </a>
                @endif

                {{-- Mobile Menu Button --}}
                <button @click="mobileMenu = !mobileMenu" class="lg:hidden p-2.5 text-primary-600 hover:bg-primary-100 rounded-xl transition-colors">
                    <i data-lucide="menu" class="w-6 h-6" x-show="!mobileMenu"></i>
                    <i data-lucide="x" class="w-6 h-6" x-show="mobileMenu" style="display: none;"></i>
                </button>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div x-show="mobileMenu" x-collapse class="lg:hidden border-t border-primary-100 py-4">
            <div class="flex flex-col gap-2">
                <a href="{{ url('/') }}" class="px-4 py-3 text-primary-700 font-medium hover:bg-primary-100 rounded-xl transition-colors">
                    Beranda
                </a>
                <a href="{{ url('/products') }}" class="px-4 py-3 text-primary-700 font-medium hover:bg-primary-100 rounded-xl transition-colors">
                    Produk
                </a>
                <a href="{{ url('/products?kategori=anyaman') }}" class="px-4 py-3 text-primary-600 hover:bg-primary-100 rounded-xl transition-colors pl-8">
                    Anyaman
                </a>
                <a href="{{ url('/products?kategori=ukiran') }}" class="px-4 py-3 text-primary-600 hover:bg-primary-100 rounded-xl transition-colors pl-8">
                    Ukiran
                </a>
                <a href="{{ url('/products?kategori=batik') }}" class="px-4 py-3 text-primary-600 hover:bg-primary-100 rounded-xl transition-colors pl-8">
                    Batik
                </a>
                <a href="{{ url('/products?kategori=rajutan') }}" class="px-4 py-3 text-primary-600 hover:bg-primary-100 rounded-xl transition-colors pl-8">
                    Rajutan
                </a>
            </div>
            
            {{-- Mobile Search --}}
            <form action="{{ route('products.page') }}" method="GET" class="mt-4 px-4">
                <div class="relative">
                    <i data-lucide="search" class="w-5 h-5 text-primary-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                    <input
                        type="text"
                        name="q"
                        placeholder="Cari produk..."
                        class="w-full pl-10 pr-4 py-3 text-sm bg-primary-50 text-primary-900 placeholder:text-primary-400
                               border border-primary-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20"
                    />
                </div>
            </form>
        </div>
    </div>
</nav>

{{-- Alpine.js for interactivity --}}
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
