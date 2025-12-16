@extends('template.main-template')

@section('title', 'Menunggu Pembayaran - Kerajinan Nusantara')

@section('content')

<section class="bg-gradient-to-r from-primary-800 to-primary-900 py-10">
    <div class="container mx-auto px-4 text-white">
        <h1 class="text-3xl font-bold mb-2">Terima kasih, pesananmu sudah dibuat! 🎉</h1>
        <p class="text-primary-200 text-sm">
            Silakan selesaikan pembayaran dalam 1 x 24 jam agar pesanan bisa diproses.
        </p>
    </div>
</section>

<section class="py-8 bg-primary-50 min-h-screen">
    <div class="container mx-auto px-4 grid lg:grid-cols-3 gap-8">

        {{-- KIRI: Detail pembayaran & pesanan --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Detail Pembayaran --}}
            <div class="bg-white rounded-2xl shadow-sm border border-primary-100 p-6">
                <h2 class="font-semibold text-lg text-primary-900 mb-4 flex items-center gap-2">
                    <i data-lucide="wallet" class="w-5 h-5 text-primary-600"></i>
                    Detail Pembayaran
                </h2>

                <div class="space-y-3 text-sm text-primary-700">
                    <div class="flex justify-between">
                        <span>ID Pesanan</span>
                        <span class="font-semibold">{{ $order->code }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span>Metode</span>
                        <span class="font-semibold text-primary-800">
                            @if($order->payment_method === 'transfer_bank')
                                Transfer Bank ({{ strtoupper($order->bank_name) }})
                            @elseif($order->payment_method === 'e_wallet')
                                E-Wallet ({{ strtoupper($order->e_wallet_name) }})
                            @else
                                COD (Bayar di Tempat)
                            @endif
                        </span>
                    </div>

                    @if($order->payment_method !== 'cod')
                        <div class="mt-4 p-4 rounded-xl bg-primary-50 border border-primary-100">
                            <p class="text-xs text-primary-500 mb-1">Nomor Rekening / VA</p>
                            <div class="flex items-center justify-between">
                                <p class="font-mono text-xl font-bold text-primary-800">
                                    {{ $order->payment_va }}
                                </p>
                                <button type="button"
                                        onclick="navigator.clipboard.writeText('{{ preg_replace('/\s+/', '', $order->payment_va) }}')"
                                        class="px-3 py-2 text-xs rounded-lg border border-primary-200 text-primary-700 hover:bg-primary-50">
                                    Salin
                                </button>
                            </div>
                            <p class="text-xs text-primary-500 mt-1">
                                a.n. {{ $order->payment_owner ?? 'Kerajinan Nusantara' }}
                            </p>
                        </div>
                    @endif

                    <div class="flex justify-between mt-4">
                        <span>Total yang harus dibayar</span>
                        <span class="text-xl font-bold text-primary-700">
                            Rp {{ number_format($order->total, 0, ',', '.') }}
                        </span>
                    </div>

                    <p class="mt-3 text-xs text-primary-500">
                        Batas pembayaran:
                        <strong>{{ optional($order->expires_at)->format('d M Y H:i') ?? '1 x 24 jam' }}</strong>
                    </p>
                </div>
            </div>

            {{-- Ringkasan Pesanan --}}
            <div class="bg-white rounded-2xl shadow-sm border border-primary-100 p-6">
                <h2 class="font-semibold text-lg text-primary-900 mb-4 flex items-center gap-2">
                    <i data-lucide="package" class="w-5 h-5 text-primary-600"></i>
                    Ringkasan Pesanan
                </h2>

                <div class="divide-y divide-primary-100">
                    @foreach($order->items as $item)
                        <div class="py-3 flex gap-4">
                            <img src="{{ $item->product_image ? asset('images/' . rawurlencode(basename($item->product_image))) : 'https://via.placeholder.com/80' }}"
                                 class="w-16 h-16 rounded-lg object-cover" alt="">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-primary-900">{{ $item->product_name }}</p>
                                <p class="text-xs text-primary-500">
                                    {{ $item->seller_name ?? 'Penjual Kerajinan' }}
                                </p>
                                <p class="text-xs text-primary-500">Qty: {{ $item->qty }}</p>
                            </div>
                            <p class="text-sm font-semibold text-primary-700">
                                Rp {{ number_format($item->total, 0, ',', '.') }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Upload Bukti Pembayaran --}}
            @if($order->payment_method !== 'cod')
            <div class="bg-white rounded-2xl shadow-sm border border-primary-100 p-6">
                <h2 class="font-semibold text-lg text-primary-900 mb-4 flex items-center gap-2">
                    <i data-lucide="image-up" class="w-5 h-5 text-primary-600"></i>
                    Upload Bukti Pembayaran
                </h2>

                <form action="{{ route('payment.upload-proof', $order->id) }}"
                      method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <input type="file" name="payment_proof" accept="image/*"
                           class="w-full text-sm border border-primary-200 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">

                    @error('payment_proof')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror

                    <p class="text-xs text-primary-500">
                        Format yang didukung: JPG, PNG. Maksimal 2MB.
                    </p>

                    <button type="submit"
                            class="px-5 py-2.5 bg-primary-600 text-white text-sm font-medium rounded-xl hover:bg-primary-700">
                        Kirim Bukti Pembayaran
                    </button>
                </form>
            </div>
            @endif
        </div>

        {{-- KANAN: Status --}}
        <div>
            <div class="bg-white rounded-2xl shadow-sm border border-primary-100 p-6">
                <h3 class="font-semibold text-primary-900 mb-3">Status Pesanan</h3>

                <p class="inline-flex items-center gap-2 px-3 py-1 rounded-full
                    @if($order->status === 'pending_payment')
                        bg-amber-50 text-amber-700
                    @elseif($order->status === 'waiting_verification')
                        bg-blue-50 text-blue-700
                    @else
                        bg-green-50 text-green-700
                    @endif
                    text-xs font-medium mb-4">
                    <span class="w-2 h-2 rounded-full
                        @if($order->status === 'pending_payment') bg-amber-500
                        @elseif($order->status === 'waiting_verification') bg-blue-500
                        @else bg-green-500 @endif
                    "></span>
                    @if($order->status === 'pending_payment')
                        Menunggu Pembayaran
                    @elseif($order->status === 'waiting_verification')
                        Menunggu Verifikasi Pembayaran
                    @else
                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                    @endif
                </p>

                <p class="text-sm text-primary-600 mb-4">
                    Setelah pembayaran terverifikasi oleh admin, status pesanan akan berubah menjadi
                    <strong>“Diproses”</strong>. Kamu bisa cek di menu <strong>Riwayat Pesanan</strong>.
                </p>

                <a href="{{ route('customer.dashboard') }}"
                   class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 text-sm border border-primary-200 rounded-xl text-primary-700 hover:bg-primary-50">
                    <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                    Kembali ke Dashboard
                </a>
            </div>
        </div>

    </div>
</section>

@endsection
