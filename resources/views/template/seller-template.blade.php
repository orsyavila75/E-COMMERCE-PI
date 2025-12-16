<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Seller Dashboard - Kerajinan Nusantara')</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#fdf8f6',
                            100: '#f9ebe4',
                            200: '#f3d5c8',
                            300: '#e9b8a3',
                            400: '#dc9275',
                            500: '#cf7352',
                            600: '#b85a3a',
                            700: '#9a4a30',
                            800: '#7d3f2b',
                            900: '#683727',
                            950: '#381a12',
                        },
                        accent: {
                            50: '#f6f5f0',
                            100: '#e8e6d9',
                            200: '#d3ceb6',
                            300: '#b9b18c',
                            400: '#a49a6c',
                            500: '#958a5d',
                            600: '#7f724e',
                            700: '#675b41',
                            800: '#574c39',
                            900: '#4b4233',
                            950: '#2a241b',
                        },
                    },
                    fontFamily: {
                        'display': ['Playfair Display', 'serif'],
                        'body': ['Poppins', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    {{-- Lucide Icons --}}
    <script src="https://unpkg.com/lucide@latest"></script>

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        html { scroll-behavior: smooth; }
        body { font-family: 'Poppins', sans-serif; }
        .font-display { font-family: 'Playfair Display', serif; }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #9a4a30; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #7d3f2b; }

        /* Sidebar active state */
        .sidebar-link.active {
            background: linear-gradient(135deg, #9a4a30 0%, #7d3f2b 100%);
            color: white;
        }
        .sidebar-link.active i { color: white; }
    </style>
</head>

<body class="bg-primary-50 min-h-screen" x-data="{ sidebarOpen: true, mobileSidebar: false }">
    <div class="flex min-h-screen">
        
        {{-- Sidebar --}}
        <aside :class="sidebarOpen ? 'w-64' : 'w-20'" 
               class="hidden lg:flex flex-col bg-white border-r border-primary-100 transition-all duration-300 fixed h-full z-40">
            
            {{-- Logo --}}
            <div class="p-4 border-b border-primary-100">
                <a href="{{ route('seller.dashboard') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-primary-600 to-primary-800 rounded-xl flex items-center justify-center shadow-lg flex-shrink-0">
                        <i data-lucide="store" class="w-6 h-6 text-white"></i>
                    </div>
                    <div x-show="sidebarOpen" x-transition class="overflow-hidden">
                        <span class="font-display text-lg font-bold text-primary-900 block leading-tight">Seller</span>
                        <span class="text-xs text-primary-500">Panel</span>
                    </div>
                </a>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
                <p x-show="sidebarOpen" class="text-xs font-semibold text-primary-400 uppercase tracking-wider mb-3 px-3">Menu Utama</p>
                
                <a href="{{ route('seller.dashboard') }}" 
                   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-primary-600 hover:bg-primary-50 transition-colors {{ request()->routeIs('seller.dashboard') ? 'active' : '' }}">
                    <i data-lucide="layout-dashboard" class="w-5 h-5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen">Dashboard</span>
                </a>

                <a href="{{ route('seller.orders') }}" 
                   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-primary-600 hover:bg-primary-50 transition-colors {{ request()->routeIs('seller.orders') ? 'active' : '' }}">
                    <i data-lucide="shopping-bag" class="w-5 h-5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen">Pesanan</span>
                    <span x-show="sidebarOpen" class="ml-auto px-2 py-0.5 text-xs font-medium bg-red-100 text-red-600 rounded-full">3</span>
                </a>

                <a href="{{ route('seller.add-product') }}" 
                   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-primary-600 hover:bg-primary-50 transition-colors {{ request()->routeIs('seller.add-product') ? 'active' : '' }}">
                    <i data-lucide="package-plus" class="w-5 h-5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen">Tambah Produk</span>
                </a>

                <a href="{{ route('seller.report') }}" 
                   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-primary-600 hover:bg-primary-50 transition-colors {{ request()->routeIs('seller.report') ? 'active' : '' }}">
                    <i data-lucide="bar-chart-3" class="w-5 h-5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen">Laporan</span>
                </a>

                <p x-show="sidebarOpen" class="text-xs font-semibold text-primary-400 uppercase tracking-wider mt-6 mb-3 px-3">Pengaturan</p>

                <a href="{{ route('seller.edit-account') }}" 
                   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-primary-600 hover:bg-primary-50 transition-colors {{ request()->routeIs('seller.edit-account') ? 'active' : '' }}">
                    <i data-lucide="settings" class="w-5 h-5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen">Pengaturan Toko</span>
                </a>

                <a href="{{ route('chat') }}" 
                   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-primary-600 hover:bg-primary-50 transition-colors">
                    <i data-lucide="message-circle" class="w-5 h-5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen">Chat</span>
                    <span x-show="sidebarOpen" class="ml-auto px-2 py-0.5 text-xs font-medium bg-primary-100 text-primary-600 rounded-full">2</span>
                </a>
            </nav>

            {{-- User Info --}}
            <div class="p-4 border-t border-primary-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-700 rounded-xl flex items-center justify-center text-white font-semibold flex-shrink-0">
                        {{ substr(Auth::user()->name ?? 'S', 0, 1) }}
                    </div>
                    <div x-show="sidebarOpen" class="flex-1 min-w-0">
                        <p class="font-medium text-primary-900 truncate">{{ Auth::user()->name ?? 'Seller' }}</p>
                        <p class="text-xs text-primary-500">Seller</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" x-show="sidebarOpen">
                        @csrf
                        <button type="submit" class="p-2 text-primary-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                            <i data-lucide="log-out" class="w-5 h-5"></i>
                        </button>
                    </form>
                </div>
            </div>

            {{-- Toggle Button --}}
            <button @click="sidebarOpen = !sidebarOpen" 
                    class="absolute -right-3 top-20 w-6 h-6 bg-white border border-primary-200 rounded-full flex items-center justify-center text-primary-600 hover:bg-primary-50 transition-colors shadow-sm">
                <i data-lucide="chevron-left" class="w-4 h-4" :class="!sidebarOpen && 'rotate-180'"></i>
            </button>
        </aside>

        {{-- Mobile Sidebar Overlay --}}
        <div x-show="mobileSidebar" x-transition:enter="transition-opacity ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="mobileSidebar = false" class="lg:hidden fixed inset-0 bg-black/50 z-40"></div>

        {{-- Mobile Sidebar --}}
        <aside x-show="mobileSidebar" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="lg:hidden fixed inset-y-0 left-0 w-64 bg-white z-50 flex flex-col">
            {{-- Same content as desktop sidebar --}}
            <div class="p-4 border-b border-primary-100 flex items-center justify-between">
                <a href="{{ route('seller.dashboard') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-primary-600 to-primary-800 rounded-xl flex items-center justify-center shadow-lg">
                        <i data-lucide="store" class="w-6 h-6 text-white"></i>
                    </div>
                    <span class="font-display text-lg font-bold text-primary-900">Seller Panel</span>
                </a>
                <button @click="mobileSidebar = false" class="p-2 text-primary-600 hover:bg-primary-100 rounded-lg">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
                <a href="{{ route('seller.dashboard') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-primary-600 hover:bg-primary-50 {{ request()->routeIs('seller.dashboard') ? 'active' : '' }}">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                    Dashboard
                </a>
                <a href="{{ route('seller.orders') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-primary-600 hover:bg-primary-50 {{ request()->routeIs('seller.orders') ? 'active' : '' }}">
                    <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                    Pesanan
                </a>
                <a href="{{ route('seller.add-product') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-primary-600 hover:bg-primary-50 {{ request()->routeIs('seller.add-product') ? 'active' : '' }}">
                    <i data-lucide="package-plus" class="w-5 h-5"></i>
                    Tambah Produk
                </a>
                <a href="{{ route('seller.report') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-primary-600 hover:bg-primary-50 {{ request()->routeIs('seller.report') ? 'active' : '' }}">
                    <i data-lucide="bar-chart-3" class="w-5 h-5"></i>
                    Laporan
                </a>
                <a href="{{ route('seller.edit-account') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-primary-600 hover:bg-primary-50 {{ request()->routeIs('seller.edit-account') ? 'active' : '' }}">
                    <i data-lucide="settings" class="w-5 h-5"></i>
                    Pengaturan
                </a>
            </nav>
        </aside>

        {{-- Main Content --}}
        <div :class="sidebarOpen ? 'lg:ml-64' : 'lg:ml-20'" class="flex-1 transition-all duration-300">
            {{-- Top Header --}}
            <header class="bg-white border-b border-primary-100 sticky top-0 z-30">
                <div class="flex items-center justify-between px-4 lg:px-8 h-16">
                    {{-- Mobile Menu Button --}}
                    <button @click="mobileSidebar = true" class="lg:hidden p-2 text-primary-600 hover:bg-primary-100 rounded-lg">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>

                    {{-- Page Title --}}
                    <div class="hidden lg:block">
                        <h1 class="font-semibold text-primary-900">@yield('page-title', 'Dashboard')</h1>
                    </div>

                    {{-- Right Actions --}}
                    <div class="flex items-center gap-3">
                        {{-- Search --}}
                        <div class="hidden md:block relative">
                            <i data-lucide="search" class="w-4 h-4 text-primary-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                            <input type="text" placeholder="Cari..." class="w-48 pl-10 pr-4 py-2 text-sm border border-primary-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                        </div>

                        {{-- Notifications --}}
                        <button class="relative p-2 text-primary-600 hover:bg-primary-100 rounded-xl transition-colors">
                            <i data-lucide="bell" class="w-5 h-5"></i>
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>

                        {{-- Back to Store --}}
                        <a href="{{ url('/') }}" class="hidden sm:flex items-center gap-2 px-4 py-2 text-sm text-primary-600 hover:bg-primary-100 rounded-xl transition-colors">
                            <i data-lucide="external-link" class="w-4 h-4"></i>
                            Lihat Toko
                        </a>
                    </div>
                </div>
            </header>

            {{-- Page Content --}}
            <main class="p-4 lg:p-8">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
