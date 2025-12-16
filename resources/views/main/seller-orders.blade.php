@extends('template.seller-template')

@section('title', 'Kelola Pesanan - Kerajinan Nusantara')
@section('page-title', 'Kelola Pesanan')

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
            <span class="text-white font-medium">Pesanan</span>
        </nav>
        <h1 class="text-3xl font-bold mb-2 tracking-tight">Daftar Pesanan Masuk</h1>
        <p class="text-primary-100 text-lg max-w-2xl">Pantau dan kelola pesanan pelanggan Anda dengan mudah dan efisien.</p>
    </div>
</div>

{{-- Stats Summary --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    @php
        $stats = [
            ['label' => 'Total Pesanan', 'value' => $orders->count(), 'icon' => 'shopping-bag', 'color' => 'blue', 'bg' => 'bg-blue-50', 'text' => 'text-blue-600'],
            ['label' => 'Perlu Dikirim', 'value' => $orders->where('status_pemesanan', 'diproses')->count(), 'icon' => 'package', 'color' => 'amber', 'bg' => 'bg-amber-50', 'text' => 'text-amber-600'],
            ['label' => 'Sedang Dikirim', 'value' => $orders->where('status_pemesanan', 'dikirim')->count(), 'icon' => 'truck', 'color' => 'indigo', 'bg' => 'bg-indigo-50', 'text' => 'text-indigo-600'],
            ['label' => 'Selesai', 'value' => $orders->where('status_pemesanan', 'selesai')->count(), 'icon' => 'check-circle', 'color' => 'green', 'bg' => 'bg-green-50', 'text' => 'text-green-600'],
        ];
    @endphp

    @foreach($stats as $stat)
        <div class="bg-white p-6 rounded-2xl border border-primary-100 shadow-sm hover:shadow-md transition-all duration-300 flex items-center gap-5 group">
            <div class="w-14 h-14 rounded-2xl {{ $stat['bg'] }} flex items-center justify-center {{ $stat['text'] }} group-hover:scale-110 transition-transform duration-300">
                <i data-lucide="{{ $stat['icon'] }}" class="w-7 h-7"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-primary-500 mb-1">{{ $stat['label'] }}</p>
                <p class="text-2xl font-bold text-primary-900">{{ $stat['value'] }}</p>
            </div>
        </div>
    @endforeach
</div>

{{-- Orders Table --}}
<div class="bg-white rounded-2xl shadow-sm border border-primary-100 overflow-hidden">
    <div class="p-6 border-b border-primary-100 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-primary-50/30">
        <h2 class="font-bold text-primary-900 flex items-center gap-2 text-lg">
            <div class="w-8 h-8 rounded-lg bg-primary-100 flex items-center justify-center text-primary-600">
                <i data-lucide="list" class="w-4 h-4"></i>
            </div>
            Data Pesanan
        </h2>
        
        <div class="flex items-center gap-3">
            <div class="relative group">
                <i data-lucide="search" class="w-4 h-4 text-primary-400 absolute left-3 top-1/2 -translate-y-1/2 group-focus-within:text-primary-600 transition-colors"></i>
                <input type="text" placeholder="Cari ID / Nama..." class="pl-10 pr-4 py-2.5 text-sm border border-primary-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all w-64">
            </div>
            <button class="p-2.5 text-primary-600 bg-white border border-primary-200 hover:bg-primary-50 rounded-xl transition-colors shadow-sm">
                <i data-lucide="filter" class="w-5 h-5"></i>
            </button>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-primary-50/50 border-b border-primary-100 text-xs uppercase tracking-wider text-primary-600 font-bold">
                    <th class="p-5 pl-6">Produk</th>
                    <th class="p-5">Customer</th>
                    <th class="p-5">Total</th>
                    <th class="p-5">Status</th>
                    <th class="p-5">Tanggal</th>
                    <th class="p-5 pr-6 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-primary-50">
                @forelse($orders as $order)
                    <tr class="hover:bg-primary-50/40 transition-colors group">
                        <td class="p-5 pl-6">
                            <div class="flex items-center gap-4">
                                <div class="relative w-14 h-14 rounded-xl overflow-hidden border border-primary-100 shadow-sm group-hover:shadow-md transition-all">
                                    <img src="{{ $order->gambar ? asset('storage/'.$order->gambar) : 'https://via.placeholder.com/150' }}" 
                                         alt="{{ $order->nama_produk }}" 
                                         class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <p class="font-bold text-primary-900 line-clamp-1 text-sm mb-1">{{ $order->nama_produk }}</p>
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs font-medium text-primary-500 bg-primary-100 px-2 py-0.5 rounded-md">Qty: {{ $order->jumlah }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="p-5">
                            <div class="flex items-center gap-2 mb-1">
                                <div class="w-6 h-6 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white text-[10px] font-bold">
                                    {{ substr($order->nama_customer, 0, 1) }}
                                </div>
                                <p class="text-sm font-semibold text-primary-900">{{ $order->nama_customer }}</p>
                            </div>
                            <p class="text-xs text-primary-400 font-mono ml-8">#{{ $order->id_pesan }}</p>
                        </td>
                        <td class="p-5">
                            <p class="text-sm font-bold text-primary-900">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</p>
                        </td>
                        <td class="p-5">
                            @php
                                $statusStyles = [
                                    'baru' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'icon' => 'alert-circle'],
                                    'diproses' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-700', 'icon' => 'loader-2'],
                                    'dikirim' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'icon' => 'truck'],
                                    'selesai' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'icon' => 'check-circle'],
                                    'dibatalkan' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'icon' => 'x-circle'],
                                ];
                                $style = $statusStyles[$order->status_pemesanan] ?? $statusStyles['dibatalkan'];
                            @endphp
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold rounded-full {{ $style['bg'] }} {{ $style['text'] }} capitalize border border-white shadow-sm">
                                <i data-lucide="{{ $style['icon'] }}" class="w-3.5 h-3.5"></i>
                                {{ $order->status_pemesanan }}
                            </span>
                        </td>
                        <td class="p-5">
                            <div class="flex flex-col">
                                <span class="text-sm font-medium text-primary-700">{{ \Carbon\Carbon::parse($order->tanggal_pesan)->format('d M Y') }}</span>
                                <span class="text-xs text-primary-400">{{ \Carbon\Carbon::parse($order->tanggal_pesan)->format('H:i') }} WIB</span>
                            </div>
                        </td>
                        <td class="p-5 pr-6 text-right">
                            <div class="relative inline-block text-left" x-data="{ open: false }">
                                <button @click="open = !open" @click.away="open = false" class="p-2 text-primary-400 hover:text-primary-600 hover:bg-primary-100 rounded-lg transition-colors">
                                    <i data-lucide="more-vertical" class="w-5 h-5"></i>
                                </button>
                                
                                {{-- Dropdown Action --}}
                                <div x-show="open" 
                                     x-transition:enter="transition ease-out duration-100"
                                     x-transition:enter-start="transform opacity-0 scale-95"
                                     x-transition:enter-end="transform opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="transform opacity-100 scale-100"
                                     x-transition:leave-end="transform opacity-0 scale-95"
                                     class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-primary-100 z-50 py-1 origin-top-right" 
                                     style="display: none;">
                                    <div class="px-4 py-2 border-b border-primary-50 bg-primary-50/50">
                                        <p class="text-xs font-bold text-primary-500 uppercase tracking-wider">Update Status</p>
                                    </div>
                                    <a href="#" class="flex items-center gap-2 px-4 py-2.5 text-sm text-primary-700 hover:bg-primary-50 transition-colors">
                                        <i data-lucide="package" class="w-4 h-4 text-amber-500"></i> Proses
                                    </a>
                                    <a href="#" class="flex items-center gap-2 px-4 py-2.5 text-sm text-primary-700 hover:bg-primary-50 transition-colors">
                                        <i data-lucide="truck" class="w-4 h-4 text-blue-500"></i> Kirim
                                    </a>
                                    <a href="#" class="flex items-center gap-2 px-4 py-2.5 text-sm text-primary-700 hover:bg-primary-50 transition-colors">
                                        <i data-lucide="check-circle" class="w-4 h-4 text-green-500"></i> Selesai
                                    </a>
                                    <div class="border-t border-primary-50 my-1"></div>
                                    <a href="#" class="flex items-center gap-2 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                        <i data-lucide="x-circle" class="w-4 h-4"></i> Batalkan
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-16 text-center">
                            <div class="w-20 h-20 bg-primary-50 rounded-full flex items-center justify-center mx-auto mb-6 animate-pulse">
                                <i data-lucide="inbox" class="w-10 h-10 text-primary-300"></i>
                            </div>
                            <h3 class="text-lg font-bold text-primary-900 mb-1">Belum ada pesanan</h3>
                            <p class="text-primary-500">Pesanan baru dari pelanggan akan muncul di sini.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    {{-- Pagination --}}
    <div class="p-4 border-t border-primary-100 flex items-center justify-between bg-primary-50/30">
        <p class="text-sm text-primary-500 font-medium">Menampilkan <span class="text-primary-900 font-bold">{{ $orders->count() }}</span> pesanan</p>
        <div class="flex gap-2">
            <button class="w-9 h-9 flex items-center justify-center rounded-xl border border-primary-200 text-primary-500 hover:bg-white hover:shadow-sm hover:text-primary-700 transition-all disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                <i data-lucide="chevron-left" class="w-4 h-4"></i>
            </button>
            <button class="w-9 h-9 flex items-center justify-center rounded-xl border border-primary-200 text-primary-500 hover:bg-white hover:shadow-sm hover:text-primary-700 transition-all disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
            </button>
        </div>
    </div>
</div>

@endsection
