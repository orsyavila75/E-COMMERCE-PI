<nav x-data="{ open: false }" class="bg-white border-b border-[#EFEBE9] sticky top-0 z-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">

            <!-- BAGIAN KIRI: Logo & Menu Utama -->
            <div class="flex items-center gap-8">
                <!-- Brand (Menyesuaikan Font E-Commerce di gambar) -->
                <a href="{{ route('seller.dashboard') }}" class="flex items-center gap-2 group">
                    <div class="w-8 h-8 rounded-lg bg-[#4A3228] text-white flex items-center justify-center font-bold text-lg">
                        S
                    </div>
                    <div>
                        <span class="block text-lg font-bold text-[#4A3228] leading-none tracking-tight">
                            SELLER PANEL
                        </span>
                        <span class="text-[10px] text-[#8D6E63] uppercase tracking-wider">
                            Kerajinan Lokal
                        </span>
                    </div>
                </a>

                <!-- Navigation Links (Desktop) - Style Outline Pill mirip tombol Login/Register -->
                <div class="hidden md:flex items-center space-x-3 ml-4">
                    <a href="{{ route('seller.dashboard') }}" 
                       class="px-5 py-2 rounded-full text-sm font-semibold transition duration-200 border
                       {{ request()->routeIs('seller.dashboard') 
                          ? 'border-[#4A3228] text-[#4A3228] bg-white shadow-sm' 
                          : 'border-transparent text-gray-500 hover:text-[#4A3228] hover:bg-[#FDFBF7]' }}">
                        Dashboard
                    </a>

                    <a href="{{ route('seller.orders') }}" 
                       class="px-5 py-2 rounded-full text-sm font-semibold transition duration-200 border
                       {{ request()->routeIs('seller.orders') 
                          ? 'border-[#4A3228] text-[#4A3228] bg-white shadow-sm' 
                          : 'border-transparent text-gray-500 hover:text-[#4A3228] hover:bg-[#FDFBF7]' }}">
                        Pesanan
                    </a>

                    <a href="{{ route('seller.add-product') }}" 
                       class="px-5 py-2 rounded-full text-sm font-semibold transition duration-200 border
                       {{ request()->routeIs('seller.add-product') 
                          ? 'border-[#4A3228] text-[#4A3228] bg-white shadow-sm' 
                          : 'border-transparent text-gray-500 hover:text-[#4A3228] hover:bg-[#FDFBF7]' }}">
                        Tambah Produk
                    </a>
                </div>
            </div>

            <!-- BAGIAN KANAN: Ikon & User Action -->
            <div class="flex items-center gap-4">

                <!-- Chat Icon -->
                <a href="{{ route('chat') }}" class="relative text-gray-400 hover:text-[#4A3228] transition p-2 hover:bg-[#FDFBF7] rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                </a>

                <div class="hidden sm:block h-8 w-px bg-gray-200"></div>

                <!-- Desktop Profile & Logout -->
                <div class="hidden sm:flex items-center gap-3">
                    <a href="{{ route('profile') }}" class="flex items-center gap-3 group">
                        <div class="w-10 h-10 rounded-full bg-[#F5F5F5] border border-gray-200 flex items-center justify-center text-gray-400 group-hover:border-[#4A3228] group-hover:text-[#4A3228] transition overflow-hidden">
                             <!-- Icon User -->
                             <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="text-xs text-left hidden lg:block">
                            <p class="font-bold text-[#4A3228]">{{ Auth::user()->name ?? 'Seller' }}</p>
                            <p class="text-gray-400">Owner</p>
                        </div>
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-full transition" title="Logout">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" class="sm:hidden p-2 text-[#4A3228] focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

            </div>
        </div>
    </div>

    <!-- Mobile Menu Dropdown -->
    <div id="mobile-menu" class="hidden sm:hidden bg-white border-t border-gray-100 shadow-xl absolute w-full left-0 top-20">
        <div class="px-6 py-6 space-y-3">
            <a href="{{ route('seller.dashboard') }}" 
               class="block px-4 py-3 rounded-xl text-base font-bold transition
               {{ request()->routeIs('seller.dashboard') ? 'bg-[#4A3228] text-white' : 'text-gray-600 hover:bg-[#FDFBF7] hover:text-[#4A3228]' }}">
                Dashboard
            </a>
            <a href="{{ route('seller.orders') }}" 
               class="block px-4 py-3 rounded-xl text-base font-bold transition
               {{ request()->routeIs('seller.orders') ? 'bg-[#4A3228] text-white' : 'text-gray-600 hover:bg-[#FDFBF7] hover:text-[#4A3228]' }}">
                Pesanan
            </a>
            <a href="{{ route('seller.add-product') }}" 
               class="block px-4 py-3 rounded-xl text-base font-bold transition
               {{ request()->routeIs('seller.add-product') ? 'bg-[#4A3228] text-white' : 'text-gray-600 hover:bg-[#FDFBF7] hover:text-[#4A3228]' }}">
                Tambah Produk
            </a>
            
            <div class="border-t border-gray-100 pt-4 mt-4">
                 <a href="{{ route('profile') }}" class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:text-[#4A3228]">
                    <span class="font-semibold">Pengaturan Akun</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-3 font-semibold text-red-600 hover:bg-red-50 rounded-xl">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');

        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
    </script>
</nav>