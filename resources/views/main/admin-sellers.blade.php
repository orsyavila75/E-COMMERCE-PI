@extends('template.admin-layout')

@section('title', 'Verifikasi Toko')
@section('header', 'Verifikasi Toko')

@section('content')
<div class="space-y-8">
    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="glass-card p-6 rounded-2xl relative overflow-hidden group">
            <div class="absolute right-0 top-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                <i data-lucide="file-text" class="w-16 h-16 text-white"></i>
            </div>
            <h3 class="text-stone-400 text-sm font-medium mb-1">Total Pengajuan</h3>
            <p class="text-3xl font-bold text-white font-display">{{ $sellers->count() }}</p>
        </div>
        <div class="glass-card p-6 rounded-2xl relative overflow-hidden group">
            <div class="absolute right-0 top-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                <i data-lucide="clock" class="w-16 h-16 text-orange-500"></i>
            </div>
            <h3 class="text-stone-400 text-sm font-medium mb-1">Menunggu Review</h3>
            <p class="text-3xl font-bold text-orange-400 font-display">{{ $sellers->where('status', 'pending')->count() }}</p>
        </div>
        <div class="glass-card p-6 rounded-2xl relative overflow-hidden group">
            <div class="absolute right-0 top-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                <i data-lucide="check-circle" class="w-16 h-16 text-green-500"></i>
            </div>
            <h3 class="text-stone-400 text-sm font-medium mb-1">Disetujui</h3>
            <p class="text-3xl font-bold text-green-400 font-display">{{ $sellers->where('status', 'approved')->count() }}</p>
        </div>
    </div>

    <!-- List -->
    <div class="space-y-4">
        <h3 class="font-display text-lg font-bold text-white tracking-wide px-1">Pengajuan Terbaru</h3>
        
        @foreach($sellers as $seller)
        <div class="glass-card p-6 rounded-2xl flex flex-col md:flex-row gap-6 items-start md:items-center hover:bg-white/5 transition-all duration-300 group border-l-4 {{ $seller->status == 'pending' ? 'border-l-orange-500' : ($seller->status == 'approved' ? 'border-l-green-500' : 'border-l-red-500') }}">
            <div class="w-16 h-16 bg-gradient-to-br from-stone-800 to-stone-900 rounded-xl flex items-center justify-center shrink-0 border border-white/10 shadow-lg group-hover:scale-105 transition-transform">
                <i data-lucide="store" class="w-8 h-8 {{ $seller->status == 'pending' ? 'text-orange-500' : ($seller->status == 'approved' ? 'text-green-500' : 'text-red-500') }}"></i>
            </div>
            <div class="flex-1">
                <div class="flex items-center gap-3 mb-2">
                    <h4 class="font-bold text-white text-lg tracking-tight group-hover:text-orange-400 transition-colors">{{ $seller->nama_toko }}</h4>
                    @if($seller->status == 'pending')
                        <span class="px-2.5 py-0.5 bg-orange-500/10 text-orange-400 border border-orange-500/20 rounded-full text-[10px] font-bold uppercase tracking-wider">Menunggu Verifikasi</span>
                    @elseif($seller->status == 'approved')
                        <span class="px-2.5 py-0.5 bg-green-500/10 text-green-400 border border-green-500/20 rounded-full text-[10px] font-bold uppercase tracking-wider">Disetujui</span>
                    @else
                        <span class="px-2.5 py-0.5 bg-red-500/10 text-red-400 border border-red-500/20 rounded-full text-[10px] font-bold uppercase tracking-wider">Ditolak</span>
                    @endif
                </div>
                <p class="text-sm text-stone-400 mb-1 flex items-center gap-2">
                    <i data-lucide="user" class="w-3 h-3"></i> {{ $seller->nama }} ({{ $seller->email }})
                </p>
                <p class="text-sm text-stone-500 line-clamp-2 font-light italic">"{{ $seller->deskripsi_toko ?? 'Tidak ada deskripsi' }}"</p>
            </div>
            <div class="flex gap-3 shrink-0 w-full md:w-auto">
                <a href="{{ route('admin.sellers.show', $seller->id_seller) }}" class="flex-1 md:flex-none px-5 py-2.5 border border-white/10 text-stone-300 rounded-xl text-sm font-medium hover:bg-white/5 hover:text-white hover:border-white/20 transition-colors">
                    <i data-lucide="eye" class="w-4 h-4 inline mr-1"></i>Detail
                </a>
                
                @if($seller->status == 'pending')
                    <form action="{{ route('admin.sellers.approve', $seller->id_seller) }}" method="POST" onsubmit="return confirm('Setujui seller ini?')">
                        @csrf
                        <button type="submit" class="flex-1 md:flex-none px-5 py-2.5 bg-gradient-to-r from-green-600 to-green-500 text-white rounded-xl text-sm font-medium hover:shadow-[0_0_15px_rgba(34,197,94,0.4)] transition-all transform hover:-translate-y-0.5">Setujui</button>
                    </form>
                    <form action="{{ route('admin.sellers.reject', $seller->id_seller) }}" method="POST" onsubmit="return confirm('Tolak seller ini?')">
                        @csrf
                        <button type="submit" class="flex-1 md:flex-none px-5 py-2.5 bg-gradient-to-r from-red-600 to-red-500 text-white rounded-xl text-sm font-medium hover:shadow-[0_0_15px_rgba(239,68,68,0.4)] transition-all transform hover:-translate-y-0.5">Tolak</button>
                    </form>
                @endif
            </div>
        </div>
        @endforeach

    </div>
</div>
@endsection
