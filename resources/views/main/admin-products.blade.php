@extends('template.admin-layout')

@section('title', 'Manajemen Produk')
@section('header', 'Koleksi Produk')

@section('content')
<div class="space-y-6">
    <!-- Filters -->
    <form method="GET" class="glass-card p-4 rounded-2xl flex flex-col md:flex-row justify-between items-center gap-4 sticky top-24 z-20 backdrop-blur-xl">
        <div class="flex gap-2 overflow-x-auto w-full md:w-auto pb-2 md:pb-0 no-scrollbar">
            <a href="{{ route('admin.products') }}" class="px-4 py-2 {{ !request('category') ? 'bg-white text-black shadow-[0_0_15px_rgba(255,255,255,0.3)]' : 'bg-white/5 text-stone-400 border border-white/10 hover:bg-white/10 hover:text-white' }} rounded-full text-sm font-medium transition-transform hover:scale-105">Semua</a>
            <button type="submit" name="category" value="anyaman" class="px-4 py-2 {{ request('category') === 'anyaman' ? 'bg-white text-black shadow-[0_0_15px_rgba(255,255,255,0.3)]' : 'bg-white/5 text-stone-400 border border-white/10 hover:bg-white/10 hover:text-white transition-all' }} rounded-full text-sm font-medium whitespace-nowrap">Anyaman</button>
            <button type="submit" name="category" value="ukiran" class="px-4 py-2 {{ request('category') === 'ukiran' ? 'bg-white text-black shadow-[0_0_15px_rgba(255,255,255,0.3)]' : 'bg-white/5 text-stone-400 border border-white/10 hover:bg-white/10 hover:text-white transition-all' }} rounded-full text-sm font-medium whitespace-nowrap">Ukiran</button>
            <button type="submit" name="category" value="batik" class="px-4 py-2 {{ request('category') === 'batik' ? 'bg-white text-black shadow-[0_0_15px_rgba(255,255,255,0.3)]' : 'bg-white/5 text-stone-400 border border-white/10 hover:bg-white/10 hover:text-white transition-all' }} rounded-full text-sm font-medium whitespace-nowrap">Batik</button>
        </div>
        <div class="relative w-full md:w-auto">
            <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-stone-500"></i>
            <input type="text" name="search" placeholder="Cari produk..." value="{{ request('search') }}" class="pl-10 pr-4 py-2 rounded-full bg-black/40 border border-white/10 text-sm text-white placeholder:text-stone-600 focus:outline-none focus:ring-1 focus:ring-orange-500/50 focus:border-orange-500/50 w-full md:w-64 transition-all hover:bg-black/60">
        </div>
    </form>

    <!-- Gallery Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse($products as $product)
        <div class="group glass-card rounded-2xl overflow-hidden hover:-translate-y-2 transition-all duration-500 hover:shadow-[0_10px_40px_rgba(0,0,0,0.5)] border border-white/5 hover:border-orange-500/30">
            <div class="aspect-[4/5] bg-gradient-to-b from-stone-800 to-black relative overflow-hidden">
                @if($product->foto_produk)
                    <img src="{{ asset($product->foto_produk) }}" alt="{{ $product->nama_produk }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                @else
                    <div class="absolute inset-0 flex items-center justify-center text-white/10 group-hover:scale-110 transition-transform duration-700">
                        <i data-lucide="image" class="w-16 h-16"></i>
                    </div>
                @endif
                <div class="absolute top-3 right-3 px-3 py-1.5 bg-black/60 backdrop-blur-md rounded-lg text-xs font-bold text-white border border-white/10 shadow-lg">
                    Rp {{ number_format($product->harga_produk, 0, ',', '.') }}
                </div>
                <!-- Overlay Actions -->
                <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center gap-3 backdrop-blur-sm">
                    <form action="{{ route('admin.products.destroy', $product->id_produk) }}" method="POST" onsubmit="return confirm('Hapus produk ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-3 bg-red-500 text-white rounded-full hover:scale-110 transition-transform shadow-[0_0_15px_rgba(239,68,68,0.4)]" title="Hapus produk">
                            <i data-lucide="trash-2" class="w-5 h-5"></i>
                        </button>
                    </form>
                </div>
            </div>
            <div class="p-5 relative">
                <div class="absolute top-0 left-0 w-full h-[1px] bg-gradient-to-r from-transparent via-white/10 to-transparent"></div>
                <h4 class="font-display font-bold text-white text-lg mb-1 truncate group-hover:text-orange-400 transition-colors">{{ $product->nama_produk }}</h4>
                <p class="text-xs text-stone-500 mb-4 flex items-center gap-1.5">
                    <i data-lucide="store" class="w-3 h-3"></i> {{ $product->seller->nama_toko ?? 'Toko Tidak Diketahui' }}
                </p>
                <div class="flex justify-between items-center">
                    <span class="text-[10px] uppercase tracking-wider px-2 py-1 {{ $product->stok_produk > 0 ? 'bg-green-500/10 text-green-400 border border-green-500/20' : 'bg-red-500/10 text-red-400 border border-red-500/20' }} rounded-md font-bold">Stok: {{ $product->stok_produk }}</span>
                    <span class="text-xs text-stone-600">#{{ str_pad($product->id_produk, 3, '0', STR_PAD_LEFT) }}</span>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <i data-lucide="inbox" class="w-16 h-16 text-white/20 mx-auto mb-4"></i>
            <p class="text-white/40">Belum ada produk</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
    <div class="flex justify-center items-center gap-2 mt-12">
        <style>
            .pagination { display: flex; gap: 0.5rem; }
            .pagination a, .pagination span {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 2.5rem;
                height: 2.5rem;
                border-radius: 0.5rem;
                border: 1px solid rgba(255,255,255,0.1);
                background: rgba(0,0,0,0.4);
                color: rgba(255,255,255,0.7);
                font-size: 0.875rem;
                font-weight: 500;
                text-decoration: none;
                transition: all 0.3s;
            }
            .pagination a:hover {
                background: rgba(255,255,255,0.1);
                border-color: rgba(255,255,255,0.2);
                color: white;
            }
            .pagination span.active {
                background: white;
                color: black;
                border-color: white;
            }
            .pagination span.disabled {
                opacity: 0.5;
                cursor: not-allowed;
            }
        </style>
        {{ $products->links() }}
    </div>
    @endif
</div>
@endsection
