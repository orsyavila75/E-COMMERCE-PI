@extends('template.admin-layout')

@section('title', 'Detail Pendaftar Toko')
@section('header', 'Detail Pendaftar Toko')

@section('content')
<div class="space-y-8">
    <!-- Back Button -->
    <a href="{{ route('admin.sellers') }}" class="inline-flex items-center gap-2 text-sm font-medium text-orange-400 hover:text-orange-300 transition-colors">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Verifikasi Toko
    </a>

    <!-- Header Section -->
    <div class="glass-card p-8 rounded-2xl">
        <div class="flex flex-col md:flex-row gap-8 items-start md:items-center">
            <div class="w-24 h-24 bg-gradient-to-br from-stone-800 to-stone-900 rounded-xl flex items-center justify-center border border-white/10 shadow-lg">
                <i data-lucide="store" class="w-12 h-12 {{ $seller->status == 'pending' ? 'text-orange-500' : ($seller->status == 'approved' ? 'text-green-500' : 'text-red-500') }}"></i>
            </div>
            <div class="flex-1">
                <div class="flex items-center gap-3 mb-3">
                    <h1 class="font-display text-3xl font-bold text-white">{{ $seller->nama_toko }}</h1>
                    @if($seller->status == 'pending')
                        <span class="px-3 py-1 bg-orange-500/10 text-orange-400 border border-orange-500/20 rounded-full text-sm font-bold uppercase tracking-wider">Menunggu Verifikasi</span>
                    @elseif($seller->status == 'approved')
                        <span class="px-3 py-1 bg-green-500/10 text-green-400 border border-green-500/20 rounded-full text-sm font-bold uppercase tracking-wider">Disetujui</span>
                    @else
                        <span class="px-3 py-1 bg-red-500/10 text-red-400 border border-red-500/20 rounded-full text-sm font-bold uppercase tracking-wider">Ditolak</span>
                    @endif
                </div>
                <p class="text-stone-400 text-sm mb-2">Kategori: <span class="text-white font-medium">{{ ucfirst($seller->kategori_toko ?? 'Tidak ditentukan') }}</span></p>
                <p class="text-stone-400 text-sm">Terdaftar: <span class="text-white font-medium">{{ $seller->created_at ? $seller->created_at->format('d M Y H:i') : '-' }}</span></p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column - Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Informasi Pemilik -->
            <div class="glass-card p-6 rounded-2xl">
                <h2 class="font-display text-lg font-bold text-white mb-6">Informasi Pemilik Toko</h2>
                <div class="space-y-4">
                    <div class="border-b border-white/5 pb-4">
                        <p class="text-xs text-stone-400 uppercase tracking-widest mb-1">Nama Pemilik</p>
                        <p class="text-lg font-semibold text-white">{{ $seller->nama }}</p>
                    </div>
                    <div class="border-b border-white/5 pb-4">
                        <p class="text-xs text-stone-400 uppercase tracking-widest mb-1">Email</p>
                        <p class="text-lg font-semibold text-white break-all">{{ $seller->email }}</p>
                    </div>
                    <div class="border-b border-white/5 pb-4">
                        <p class="text-xs text-stone-400 uppercase tracking-widest mb-1">Nomor Telepon</p>
                        <p class="text-lg font-semibold text-white">{{ $seller->no_telp ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-stone-400 uppercase tracking-widest mb-1">Alamat</p>
                        <p class="text-sm text-stone-300">{{ $seller->alamat ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Informasi Toko -->
            <div class="glass-card p-6 rounded-2xl">
                <h2 class="font-display text-lg font-bold text-white mb-6">Informasi Toko</h2>
                <div class="space-y-4">
                    <div class="border-b border-white/5 pb-4">
                        <p class="text-xs text-stone-400 uppercase tracking-widest mb-1">Nama Toko</p>
                        <p class="text-lg font-semibold text-white">{{ $seller->nama_toko }}</p>
                    </div>
                    <div class="border-b border-white/5 pb-4">
                        <p class="text-xs text-stone-400 uppercase tracking-widest mb-1">Kategori Toko</p>
                        <p class="text-lg font-semibold text-white">{{ ucfirst($seller->kategori_toko ?? 'Tidak ditentukan') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-stone-400 uppercase tracking-widest mb-2">Deskripsi Toko</p>
                        <div class="bg-black/20 p-4 rounded-lg border border-white/5 max-h-32 overflow-y-auto">
                            <p class="text-sm text-stone-300 leading-relaxed">{{ $seller->deskripsi_toko ?? 'Tidak ada deskripsi' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Actions & Summary -->
        <div class="space-y-6">
            <!-- Summary Card -->
            <div class="glass-card p-6 rounded-2xl">
                <h3 class="font-display text-lg font-bold text-white mb-6">Ringkasan Status</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 bg-black/20 rounded-lg border border-white/5">
                        <span class="text-sm text-stone-400">Status Toko</span>
                        <span class="px-2.5 py-0.5 {{ $seller->status == 'pending' ? 'bg-orange-500/10 text-orange-400 border border-orange-500/20' : ($seller->status == 'approved' ? 'bg-green-500/10 text-green-400 border border-green-500/20' : 'bg-red-500/10 text-red-400 border border-red-500/20') }} rounded-full text-[10px] font-bold uppercase tracking-wider">{{ ucfirst($seller->status) }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-black/20 rounded-lg border border-white/5">
                        <span class="text-sm text-stone-400">Terdaftar Sejak</span>
                        <span class="text-sm font-semibold text-white">{{ $seller->created_at ? $seller->created_at->format('d M Y') : '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            @if($seller->status == 'pending')
            <div class="glass-card p-6 rounded-2xl space-y-3">
                <h3 class="font-display text-sm font-bold text-white mb-4">Tindakan Verifikasi</h3>
                
                <form action="{{ route('admin.sellers.approve', $seller->id_seller) }}" method="POST">
                    @csrf
                    <button type="submit" onclick="return confirm('Setujui pendaftar toko ini?')" class="w-full px-4 py-3 bg-gradient-to-r from-green-600 to-green-500 text-white rounded-lg text-sm font-semibold hover:shadow-[0_0_20px_rgba(34,197,94,0.4)] transition-all transform hover:-translate-y-0.5">
                        <i data-lucide="check-circle" class="w-4 h-4 inline mr-2"></i> Setujui Pendaftar
                    </button>
                </form>

                <form action="{{ route('admin.sellers.reject', $seller->id_seller) }}" method="POST">
                    @csrf
                    <button type="submit" onclick="return confirm('Tolak pendaftar toko ini?')" class="w-full px-4 py-3 bg-gradient-to-r from-red-600 to-red-500 text-white rounded-lg text-sm font-semibold hover:shadow-[0_0_20px_rgba(239,68,68,0.4)] transition-all transform hover:-translate-y-0.5">
                        <i data-lucide="x-circle" class="w-4 h-4 inline mr-2"></i> Tolak Pendaftar
                    </button>
                </form>
            </div>
            @else
            <div class="glass-card p-6 rounded-2xl bg-stone-900/50 border border-stone-700/50">
                <p class="text-sm text-stone-400 text-center">
                    Status {{ $seller->status === 'approved' ? 'persetujuan' : 'penolakan' }} sudah diproses
                </p>
            </div>
            @endif

            <!-- Info Box -->
            <div class="glass-card p-4 rounded-lg bg-blue-500/5 border border-blue-500/20">
                <div class="flex gap-3">
                    <i data-lucide="info" class="w-5 h-5 text-blue-400 shrink-0 mt-0.5"></i>
                    <div class="text-sm text-blue-300">
                        <p class="font-semibold mb-1">Verifikasi Penting</p>
                        <p class="text-xs">Pastikan semua informasi pendaftar sudah lengkap dan valid sebelum memberikan persetujuan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
