<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Karya Nusantara</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #2a1810; /* primary-950 equivalent */
            background-image: radial-gradient(circle at top right, #431407 0%, #2a1810 40%, #0f0502 100%);
            color: #e7e5e4; /* stone-200 */
        }
        .font-display {
            font-family: 'Playfair Display', serif;
        }
        
        /* Glassmorphism Utilities */
        .glass-panel {
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .glass-sidebar {
            background: rgba(15, 5, 2, 0.6);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-right: 1px solid rgba(255, 255, 255, 0.05);
        }

        .glass-card {
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.05) 0%, rgba(255, 255, 255, 0.01) 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        }

        /* Navigation Active State */
        .nav-item.active {
            background: linear-gradient(90deg, rgba(234, 88, 12, 0.15) 0%, rgba(234, 88, 12, 0) 100%);
            color: #fdba74; /* orange-300 */
            border-left: 3px solid #f97316; /* orange-500 */
        }
        .nav-item:hover:not(.active) {
            background: rgba(255, 255, 255, 0.03);
            color: #fdba74;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="antialiased min-h-screen flex selection:bg-orange-500/30 selection:text-orange-200">

    <!-- Sidebar -->
    <aside class="w-72 glass-sidebar flex flex-col fixed h-full z-40 transition-transform duration-300 transform -translate-x-full md:translate-x-0" id="sidebar">
        <!-- Logo -->
        <div class="h-24 flex items-center px-8 border-b border-white/5">
            <div class="flex items-center gap-4 group cursor-pointer">
                <div class="relative">
                    <div class="absolute inset-0 bg-orange-500 blur-lg opacity-20 group-hover:opacity-40 transition-opacity duration-500"></div>
                    <div class="relative w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-700 rounded-xl flex items-center justify-center text-white shadow-lg border border-white/10">
                        <i data-lucide="crown" class="w-5 h-5"></i>
                    </div>
                </div>
                <div>
                    <span class="font-display font-bold text-xl text-white tracking-wide">Kerajinan Tangan</span>
                    <p class="text-[10px] text-white/40 uppercase tracking-[0.2em]">Admin Panel</p>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto py-8 px-4 space-y-2">
            <p class="px-4 text-[10px] font-bold text-white/30 uppercase tracking-widest mb-4">Main Menu</p>
            
            <a href="{{ route('admin.dashboard') }}" class="nav-item flex items-center gap-4 px-4 py-3.5 rounded-r-xl text-sm font-medium text-stone-400 transition-all duration-300 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i data-lucide="layout-grid" class="w-5 h-5"></i>
                Dashboard
            </a>
            
            <a href="{{ route('admin.users') }}" class="nav-item flex items-center gap-4 px-4 py-3.5 rounded-r-xl text-sm font-medium text-stone-400 transition-all duration-300 {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                <i data-lucide="users" class="w-5 h-5"></i>
                Pengguna
            </a>

            <a href="{{ route('admin.sellers') }}" class="nav-item flex items-center gap-4 px-4 py-3.5 rounded-r-xl text-sm font-medium text-stone-400 transition-all duration-300 {{ request()->routeIs('admin.sellers') ? 'active' : '' }}">
                <i data-lucide="store" class="w-5 h-5"></i>
                Verifikasi Toko
                @if(isset($pendingSellersCount) && $pendingSellersCount > 0)
                    <span class="ml-auto bg-orange-500/20 text-orange-400 border border-orange-500/20 text-[10px] font-bold px-2 py-0.5 rounded-full shadow-[0_0_10px_rgba(249,115,22,0.2)]">{{ $pendingSellersCount }}</span>
                @endif
            </a>

            <a href="{{ route('admin.products') }}" class="nav-item flex items-center gap-4 px-4 py-3.5 rounded-r-xl text-sm font-medium text-stone-400 transition-all duration-300 {{ request()->routeIs('admin.products') ? 'active' : '' }}">
                <i data-lucide="gem" class="w-5 h-5"></i>
                Koleksi Produk
            </a>

            <a href="{{ route('admin.transactions') }}" class="nav-item flex items-center gap-4 px-4 py-3.5 rounded-r-xl text-sm font-medium text-stone-400 transition-all duration-300 {{ request()->routeIs('admin.transactions') ? 'active' : '' }}">
                <i data-lucide="receipt" class="w-5 h-5"></i>
                Transaksi
            </a>

            <p class="px-4 text-[10px] font-bold text-white/30 uppercase tracking-widest mt-8 mb-4">System</p>

            <a href="#" class="nav-item flex items-center gap-4 px-4 py-3.5 rounded-r-xl text-sm font-medium text-stone-400 transition-all duration-300">
                <i data-lucide="settings-2" class="w-5 h-5"></i>
                Pengaturan
            </a>
        </nav>

        <!-- User Profile -->
        <div class="p-6 border-t border-white/5 bg-black/20">
            <div class="flex items-center gap-4">
                <div class="relative">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-stone-700 to-stone-800 flex items-center justify-center text-white font-display font-bold border border-white/10">
                        A
                    </div>
                    <div class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-500 rounded-full border-2 border-[#1a100c]"></div>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-white truncate">{{ Auth::guard('admin')->user()->nama_admin ?? 'Admin' }}</p>
                    <p class="text-xs text-white/40 truncate">{{ Auth::guard('admin')->user()->email }}</p>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-white/30 hover:text-red-400 transition-colors p-2 hover:bg-white/5 rounded-lg">
                        <i data-lucide="log-out" class="w-4 h-4"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 md:ml-72 h-full overflow-y-auto relative">
        <!-- Ambient Background Glow -->
        <div class="fixed top-0 left-0 w-full h-full pointer-events-none z-0">
            <div class="absolute top-[-10%] right-[-5%] w-[500px] h-[500px] bg-orange-600/10 rounded-full blur-[120px]"></div>
            <div class="absolute bottom-[-10%] left-[20%] w-[400px] h-[400px] bg-blue-600/5 rounded-full blur-[100px]"></div>
        </div>

        <!-- Header -->
        <header class="sticky top-0 z-30 px-8 py-6 flex items-center justify-between glass-panel border-x-0 border-t-0">
            <div class="flex items-center gap-4">
                <button class="md:hidden text-white/60 hover:text-white" onclick="document.getElementById('sidebar').classList.toggle('-translate-x-full')">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>
                <div>
                    <h1 class="font-display text-2xl font-bold text-white tracking-tight">@yield('header', 'Dashboard')</h1>
                    <p class="text-xs text-white/40 mt-1">Selamat datang kembali di panel admin.</p>
                </div>
            </div>

            <div class="flex items-center gap-6">
                <!-- Search -->
                <div class="relative hidden md:block group">
                    <div class="absolute inset-0 bg-white/5 rounded-full blur-sm opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative">
                        <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-white/30 group-focus-within:text-orange-400 transition-colors"></i>
                        <input type="text" placeholder="Cari data..." class="pl-10 pr-4 py-2.5 rounded-full bg-black/20 border border-white/5 text-sm text-white placeholder:text-white/20 focus:outline-none focus:ring-1 focus:ring-orange-500/50 focus:border-orange-500/50 w-64 transition-all hover:bg-black/30">
                    </div>
                </div>

                <!-- Notifications -->
                <button class="relative w-10 h-10 rounded-full bg-white/5 hover:bg-white/10 flex items-center justify-center text-white/60 hover:text-white transition-all border border-white/5 hover:border-white/10 group">
                    <i data-lucide="bell" class="w-5 h-5 group-hover:animate-swing"></i>
                    <span class="absolute top-2 right-2.5 w-2 h-2 bg-orange-500 rounded-full shadow-[0_0_8px_rgba(249,115,22,0.6)]"></span>
                </button>
            </div>
        </header>

        <!-- Content -->
        <div class="p-8 relative z-10">
            @yield('content')
        </div>
    </main>

    <script>
        lucide.createIcons();
    </script>
    @stack('scripts')
</body>
</html>
