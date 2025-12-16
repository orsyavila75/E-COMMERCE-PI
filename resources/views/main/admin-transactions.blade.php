@extends('template.admin-layout')

@section('title', 'Transaksi')
@section('header', 'Riwayat Transaksi')

@section('content')
<div class="glass-card rounded-2xl overflow-hidden">
    <div class="p-6 border-b border-white/5 flex justify-between items-center">
        <h3 class="font-display text-lg font-bold text-white tracking-wide">Semua Transaksi</h3>
        <button class="px-4 py-2 bg-white/5 text-stone-300 rounded-lg text-sm font-medium hover:bg-white/10 transition-colors border border-white/5 hover:text-white">
            <i data-lucide="download" class="w-4 h-4 inline mr-2"></i> Export CSV
        </button>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-white/5 text-stone-400 text-xs uppercase tracking-wider font-medium">
                <tr>
                    <th class="px-6 py-4">ID Order</th>
                    <th class="px-6 py-4">Pelanggan</th>
                    <th class="px-6 py-4">Produk</th>
                    <th class="px-6 py-4">Total</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($transactions as $transaction)
                <tr class="hover:bg-white/5 transition-colors group">
                    <td class="px-6 py-4 font-mono text-xs text-orange-400 group-hover:text-orange-300 transition-colors">#ORD-{{ str_pad($transaction->id_pesan, 4, '0', STR_PAD_LEFT) }}</td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-stone-200 group-hover:text-white transition-colors">
                            Customer #{{ $transaction->id_customer }}
                        </div>
                        <div class="text-xs text-stone-500">ID: {{ $transaction->id_customer }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-stone-400">
                        {{ $transaction->jumlah_barang }} item(s)
                    </td>
                    <td class="px-6 py-4 font-medium text-white">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        @php
                            $statusConfig = [
                                'selesai' => ['color' => 'green', 'icon' => 'check', 'label' => 'Selesai'],
                                'diproses' => ['color' => 'yellow', 'icon' => 'loader-2', 'label' => 'Diproses', 'spin' => true],
                                'pending' => ['color' => 'stone', 'icon' => 'clock', 'label' => 'Menunggu Pembayaran'],
                                'dikirim' => ['color' => 'blue', 'icon' => 'truck', 'label' => 'Dikirim'],
                            ];
                            $status = $statusConfig[$transaction->status_pemesanan] ?? ['color' => 'stone', 'icon' => 'help-circle', 'label' => ucfirst($transaction->status_pemesanan)];
                        @endphp
                        <span class="px-2.5 py-1 bg-{{ $status['color'] }}-500/10 text-{{ $status['color'] }}-400 rounded-full text-xs font-medium border border-{{ $status['color'] }}-500/20 flex w-fit items-center gap-1.5">
                            <i data-lucide="{{ $status['icon'] }}" class="w-3 h-3 {{ isset($status['spin']) ? 'animate-spin' : '' }}"></i> {{ $status['label'] }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-stone-500">
                        {{ $transaction->tanggal_pesan ? \Carbon\Carbon::parse($transaction->tanggal_pesan)->format('d M Y') : '-' }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button class="text-stone-500 hover:text-white transition-colors p-2 hover:bg-white/10 rounded-lg">
                            <i data-lucide="eye" class="w-5 h-5"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center gap-4">
                            <div class="w-16 h-16 bg-white/5 rounded-full flex items-center justify-center">
                                <i data-lucide="inbox" class="w-8 h-8 text-stone-600"></i>
                            </div>
                            <div>
                                <p class="text-stone-400 font-medium">Tidak ada transaksi</p>
                                <p class="text-sm text-stone-600 mt-1">Belum ada transaksi yang tercatat dalam sistem.</p>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if($transactions->hasPages())
    <div class="p-4 border-t border-white/5 flex justify-between items-center bg-black/20">
        <span class="text-sm text-stone-500">
            Menampilkan {{ $transactions->firstItem() }}-{{ $transactions->lastItem() }} dari {{ $transactions->total() }} transaksi
        </span>
        <div class="flex gap-2">
            @if($transactions->onFirstPage())
                <button disabled class="px-3 py-1.5 border border-white/10 rounded-lg text-sm text-stone-600 cursor-not-allowed opacity-50">Previous</button>
            @else
                <a href="{{ $transactions->previousPageUrl() }}" class="px-3 py-1.5 border border-white/10 rounded-lg text-sm text-stone-400 hover:bg-white/5 hover:text-white transition-colors">Previous</a>
            @endif

            @if($transactions->hasMorePages())
                <a href="{{ $transactions->nextPageUrl() }}" class="px-3 py-1.5 border border-white/10 rounded-lg text-sm text-stone-400 hover:bg-white/5 hover:text-white transition-colors">Next</a>
            @else
                <button disabled class="px-3 py-1.5 border border-white/10 rounded-lg text-sm text-stone-600 cursor-not-allowed opacity-50">Next</button>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection
