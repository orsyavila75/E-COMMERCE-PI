@extends('template.main-template')

@section('title', 'Checkout - Kerajinan Nusantara')

@section('content')

@php
    // Fallback kalau controller belum mengirim variabel
    $checkoutItems = $checkoutItems ?? [];
    $subtotal      = $subtotal ?? 0;
    $shipping      = $shipping ?? 25000;
    $total         = $total ?? ($subtotal + $shipping);

    // Hitung total qty yang tampil di ringkasan
    if (is_array($checkoutItems)) {
        $itemCount = 0;
        foreach ($checkoutItems as $it) {
            $itemCount += (int)($it['qty'] ?? 0);
        }
    } else {
        // kalau suatu saat $checkoutItems dikirim sebagai collection
        $itemCount = collect($checkoutItems)->sum('qty');
    }
@endphp

{{-- Hero Banner --}}
<section class="bg-gradient-to-r from-primary-800 to-primary-900 py-12 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 right-0 w-96 h-96 bg-white rounded-full blur-3xl"></div>
    </div>
    <div class="container mx-auto px-4 relative z-10">
        <nav class="flex items-center gap-2 text-primary-300 text-sm mb-4">
            <a href="{{ url('/') }}" class="hover:text-white transition-colors">Beranda</a>
            <i data-lucide="chevron-right" class="w-4 h-4"></i>
            <a href="{{ route('cart') }}" class="hover:text-white transition-colors">Keranjang</a>
            <i data-lucide="chevron-right" class="w-4 h-4"></i>
            <span class="text-white">Checkout</span>
        </nav>
        <h1 class="font-display text-3xl md:text-4xl font-bold text-white flex items-center gap-3">
            <i data-lucide="credit-card" class="w-8 h-8"></i>
            Checkout
        </h1>
    </div>
</section>

{{-- Main Content --}}
<section class="py-8 bg-primary-50 min-h-screen">
    <div class="container mx-auto px-4">
        <form method="POST" action="{{ route('checkout.submit') }}">
            @csrf
            <div class="grid lg:grid-cols-3 gap-8">
                
                {{-- LEFT COLUMN --}}
                <div class="lg:col-span-2 space-y-6">
                    
                    {{-- Alamat Pengiriman --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-primary-100 overflow-hidden">
                        <div class="p-6 border-b border-primary-100">
                            <h2 class="font-semibold text-lg text-primary-900 flex items-center gap-2">
                                <i data-lucide="map-pin" class="w-5 h-5 text-primary-600"></i>
                                Alamat Pengiriman
                            </h2>
                        </div>
                        <div class="p-6">
                            <div class="border-2 border-primary-500 rounded-xl p-4 mb-4 relative bg-primary-50/50">
                                <span class="absolute top-3 right-3 px-2 py-1 text-xs font-medium bg-primary-600 text-white rounded-full">Utama</span>
                                <div class="flex items-start gap-3">
                                    <input type="radio" name="address" value="main" checked class="mt-1 w-4 h-4 text-primary-600 focus:ring-primary-500">
                                    <div>
                                        <h4 class="font-medium text-primary-900">{{ Auth::user()->name ?? 'User' }}</h4>
                                        <p class="text-sm text-primary-500">{{ Auth::user()->no_telepon ?? '08xxxxxxxxxx' }}</p>
                                        <p class="text-sm text-primary-600 mt-1">
                                            {{ Auth::user()->alamat ?? 'Jl. Kerajinan No. 123, Yogyakarta, Indonesia' }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <button type="button"
                                class="w-full py-3 border-2 border-dashed border-primary-300 rounded-xl text-primary-600 font-medium hover:border-primary-500 hover:bg-primary-50 transition-colors flex items-center justify-center gap-2">
                                <i data-lucide="plus" class="w-4 h-4"></i>
                                Tambah Alamat Baru
                            </button>
                        </div>
                    </div>

                    {{-- Pesanan Anda --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-primary-100 overflow-hidden">
                        <div class="p-6 border-b border-primary-100 flex items-center justify-between">
                            <h2 class="font-semibold text-lg text-primary-900 flex items-center gap-2">
                                <i data-lucide="package" class="w-5 h-5 text-primary-600"></i>
                                Pesanan Anda
                            </h2>
                            <a href="{{ route('cart') }}" class="text-sm text-primary-600 hover:text-primary-800">
                                Ubah pesanan
                            </a>
                        </div>

                        @if(count($checkoutItems) > 0)
                            <div class="divide-y divide-primary-100">
                                @foreach($checkoutItems as $item)
                                    @php
                                        $name   = $item['name'] ?? 'Produk';
                                        $price  = (int)($item['price'] ?? 0);
                                        $qty    = (int)($item['qty'] ?? 1);
                                        $image  = $item['image'] ?? null;
                                        $seller = $item['seller'] ?? 'Toko Kerajinan';
                                        $fallbackImage = 'https://images.unsplash.com/photo-1590874103328-eac38a683ce7?w=100&h=100&fit=crop';
                                        $src = $image ? asset('images/' . rawurlencode(basename($image))) : $fallbackImage;
                                    @endphp

                                    {{-- Hidden input (kalau nanti mau diproses di controller berdasarkan request) --}}
                                    <input type="hidden" name="items[{{ $loop->index }}][slug]"  value="{{ $item['slug'] ?? '' }}">
                                    <input type="hidden" name="items[{{ $loop->index }}][qty]"   value="{{ $qty }}">
                                    <input type="hidden" name="items[{{ $loop->index }}][price]" value="{{ $price }}">

                                    <div class="p-4 flex gap-4">
                                        <img src="{{ $src }}" alt="{{ $name }}" class="w-20 h-20 object-cover rounded-xl">
                                        <div class="flex-1">
                                            <h4 class="font-medium text-primary-900">{{ $name }}</h4>
                                            <p class="text-sm text-primary-500">{{ $seller }}</p>
                                            <div class="flex items-center justify-between mt-2">
                                                <span class="text-sm text-primary-500">Qty: {{ $qty }}</span>
                                                <span class="font-semibold text-primary-700">
                                                    Rp {{ number_format($price, 0, ',', '.') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="p-6 text-center text-primary-500">
                                Tidak ada produk untuk di-checkout. Silakan kembali ke keranjang.
                            </div>
                        @endif
                    </div>

                    {{-- Metode Pembayaran --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-primary-100 overflow-hidden">
                        <div class="p-6 border-b border-primary-100">
                            <h2 class="font-semibold text-lg text-primary-900 flex items-center gap-2">
                                <i data-lucide="wallet" class="w-5 h-5 text-primary-600"></i>
                                Metode Pembayaran
                            </h2>
                        </div>
                        <div class="p-6 space-y-4" id="payment-method-wrapper">

                            {{-- Transfer Bank --}}
                            <div class="payment-option border border-primary-500 bg-primary-50 rounded-xl overflow-hidden"
                                 data-method="transfer_bank">
                                <label class="flex items-center gap-4 p-4 cursor-pointer">
                                    <input type="radio" name="payment_method" value="transfer_bank" checked
                                           class="w-4 h-4 text-primary-600 focus:ring-primary-500">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i data-lucide="building-2" class="w-5 h-5 text-blue-600"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-medium text-primary-900">Transfer Bank</p>
                                        <p class="text-sm text-primary-500">BCA, Mandiri, BNI, BRI</p>
                                    </div>
                                </label>

                                {{-- DETAIL TRANSFER BANK --}}
                                <div class="payment-detail px-4 pb-4 pl-14 space-y-3" id="transfer-bank-detail">
                                    <div>
                                        <label class="block text-sm font-medium text-primary-700 mb-1">
                                            Pilih Bank
                                        </label>
                                        <select name="bank_name" id="bank-select"
                                                class="w-full px-4 py-2 border border-primary-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                                            <option value="" selected disabled>-- Pilih Bank --</option>
                                            <option value="bca">BCA (Bank Central Asia)</option>
                                            <option value="mandiri">Bank Mandiri</option>
                                            <option value="bni">BNI (Bank Negara Indonesia)</option>
                                            <option value="bri">BRI (Bank Rakyat Indonesia)</option>
                                        </select>
                                    </div>

                                    <div id="bank-info" class="hidden mt-2 rounded-lg bg-primary-50 border border-primary-100 p-3 text-sm">
                                        <p class="text-primary-600 mb-1">
                                            Silakan transfer ke rekening berikut:
                                        </p>
                                        <p class="font-semibold text-primary-900" id="bank-info-name">Bank -</p>
                                        <p class="font-mono text-lg font-semibold text-primary-800" id="bank-info-va">
                                            0000 0000 0000
                                        </p>
                                        <p class="text-xs text-primary-500">
                                            a.n. <span id="bank-info-owner">Kerajinan Nusantara</span>
                                        </p>
                                    </div>

                                    <div class="mt-3 text-xs text-primary-500 space-y-1">
                                        <p class="font-semibold text-primary-700">Langkah pembayaran:</p>
                                        <ol class="list-decimal list-inside space-y-1">
                                            <li>Pilih menu <strong>Transfer Antar Bank / Virtual Account</strong> di m-banking / ATM.</li>
                                            <li>Masukkan <strong>nomor rekening / VA</strong> yang tertera di atas.</li>
                                            <li>Pastikan nama penerima adalah <strong>Kerajinan Nusantara</strong>.</li>
                                            <li>Selesaikan pembayaran sebelum <strong>1 x 24 jam</strong>.</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>

                            {{-- E-Wallet --}}
                            <div class="payment-option border border-primary-200 rounded-xl overflow-hidden"
                                 data-method="e_wallet">
                                <label class="flex items-center gap-4 p-4 cursor-pointer">
                                    <input type="radio" name="payment_method" value="e_wallet"
                                           class="w-4 h-4 text-primary-600 focus:ring-primary-500">
                                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                        <i data-lucide="smartphone" class="w-5 h-5 text-green-600"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-medium text-primary-900">E-Wallet</p>
                                        <p class="text-sm text-primary-500">GoPay, OVO, DANA, ShopeePay</p>
                                    </div>
                                </label>
                                <div class="payment-detail px-4 pb-4 pl-14 hidden" id="ewallet-detail">
                                    <label class="block text-sm font-medium text-primary-700 mb-1">
                                        Pilih E-Wallet
                                    </label>
                                    <select name="e_wallet_name"
                                            class="w-full px-4 py-2 border border-primary-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                                        <option value="" disabled selected>-- Pilih E-Wallet --</option>
                                        <option value="gopay">GoPay</option>
                                        <option value="ovo">OVO</option>
                                        <option value="dana">DANA</option>
                                        <option value="shopeepay">ShopeePay</option>
                                    </select>
                                    <p class="mt-2 text-xs text-primary-500">
                                        Setelah klik <strong>Bayar Sekarang</strong>, Anda akan diarahkan ke halaman instruksi pembayaran e-wallet.
                                    </p>
                                </div>
                            </div>

                            {{-- COD --}}
                            <div class="payment-option border border-primary-200 rounded-xl overflow-hidden"
                                 data-method="cod">
                                <label class="flex items-center gap-4 p-4 cursor-pointer">
                                    <input type="radio" name="payment_method" value="cod"
                                           class="w-4 h-4 text-primary-600 focus:ring-primary-500">
                                    <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                                        <i data-lucide="banknote" class="w-5 h-5 text-amber-600"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-medium text-primary-900">COD (Bayar di Tempat)</p>
                                        <p class="text-sm text-primary-500">Bayar saat barang diterima kurir</p>
                                    </div>
                                </label>
                                <div class="payment-detail px-4 pb-4 pl-14 hidden" id="cod-detail">
                                    <p class="text-xs text-primary-500">
                                        Pastikan Anda menyiapkan uang pas saat kurir datang. Tidak semua daerah mendukung COD.
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- Catatan --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-primary-100 overflow-hidden">
                        <div class="p-6 border-b border-primary-100">
                            <h2 class="font-semibold text-lg text-primary-900 flex items-center gap-2">
                                <i data-lucide="message-square" class="w-5 h-5 text-primary-600"></i>
                                Catatan untuk Penjual
                            </h2>
                        </div>
                        <div class="p-6">
                            <textarea name="seller_notes" rows="3" placeholder="Opsional: Tambahkan catatan khusus untuk penjual..."
                                      class="w-full px-4 py-3 border border-primary-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 resize-none"></textarea>
                        </div>
                    </div>
                </div>

                {{-- RIGHT COLUMN --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-sm border border-primary-100 p-6 sticky top-24">
                        <h2 class="font-semibold text-lg text-primary-900 mb-6 flex items-center gap-2">
                            <i data-lucide="receipt" class="w-5 h-5 text-primary-600"></i>
                            Ringkasan Pembayaran
                        </h2>

                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between text-primary-600">
                                <span>Subtotal ({{ $itemCount }} barang)</span>
                                <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-primary-600">
                                <span>Ongkos Kirim</span>
                                <span>Rp {{ number_format($shipping, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-primary-600">
                                <span>Diskon</span>
                                <span class="text-green-600">- Rp 0</span>
                            </div>
                            <div class="border-t border-primary-200 pt-4">
                                <div class="flex justify-between">
                                    <span class="font-semibold text-primary-900">Total Pembayaran</span>
                                    <span class="text-xl font-bold text-primary-700">
                                        Rp {{ number_format($total, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Kode Promo --}}
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-primary-700 mb-2">Kode Promo</label>
                            <div class="flex gap-2">
                                <input type="text" name="promo_code" placeholder="Masukkan kode"
                                       class="flex-1 px-4 py-2.5 border border-primary-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                                <button type="button" class="px-4 py-2.5 bg-primary-100 text-primary-700 font-medium rounded-xl hover:bg-primary-200 transition-colors text-sm">
                                    Terapkan
                                </button>
                            </div>
                        </div>

                        {{-- Terms --}}
                        <label class="flex items-start gap-3 mb-6 cursor-pointer">
                            <input type="checkbox" required
                                   class="mt-1 w-4 h-4 rounded border-primary-300 text-primary-600 focus:ring-primary-500">
                            <span class="text-sm text-primary-600">
                                Saya setuju dengan <a href="#" class="text-primary-700 font-medium hover:underline">Syarat &amp; Ketentuan</a> pembelian
                            </span>
                        </label>

                        {{-- Submit --}}
                        <button type="submit"
                                class="btn-shine w-full py-4 bg-gradient-to-r from-primary-600 to-primary-700 text-white font-semibold rounded-xl hover:from-primary-700 hover:to-primary-800 transition-all shadow-lg shadow-primary-500/30 flex items-center justify-center gap-2">
                            <i data-lucide="lock" class="w-5 h-5"></i>
                            Bayar Sekarang
                        </button>

                        <div class="mt-4 flex items-center justify-center gap-2 text-sm text-primary-500">
                            <i data-lucide="shield-check" class="w-4 h-4"></i>
                            Transaksi aman &amp; terenkripsi
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

{{-- Script sederhana untuk handle UI metode pembayaran + bank info --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const paymentOptions = document.querySelectorAll('.payment-option');
    const paymentRadios  = document.querySelectorAll('input[name="payment_method"]');

    function setActivePayment(method) {
        paymentOptions.forEach(opt => {
            const optMethod = opt.getAttribute('data-method');
            const detail = opt.querySelector('.payment-detail');

            if (optMethod === method) {
                opt.classList.add('border-primary-500', 'bg-primary-50');
                opt.classList.remove('border-primary-200');
                if (detail) detail.classList.remove('hidden');
            } else {
                opt.classList.remove('border-primary-500', 'bg-primary-50');
                opt.classList.add('border-primary-200');
                if (detail) detail.classList.add('hidden');
            }
        });
    }

    paymentRadios.forEach(radio => {
        radio.addEventListener('change', () => setActivePayment(radio.value));
    });

    // initial
    const checked = document.querySelector('input[name="payment_method"]:checked');
    if (checked) setActivePayment(checked.value);

    // Bank info
    const bankSelect = document.getElementById('bank-select');
    const bankInfo   = document.getElementById('bank-info');
    const bankNameEl = document.getElementById('bank-info-name');
    const bankVaEl   = document.getElementById('bank-info-va');
    const bankOwnerEl= document.getElementById('bank-info-owner');

    if (bankSelect) {
        const bankData = {
            bca:     { label: 'BCA',     va: '1234 5678 9012', owner: 'Kerajinan Nusantara' },
            mandiri: { label: 'Mandiri', va: '9876 5432 1098', owner: 'Kerajinan Nusantara' },
            bni:     { label: 'BNI',     va: '8101 2233 4455', owner: 'Kerajinan Nusantara' },
            bri:     { label: 'BRI',     va: '0022 3344 5566', owner: 'Kerajinan Nusantara' },
        };

        bankSelect.addEventListener('change', function () {
            const val = this.value;
            if (bankData[val]) {
                bankNameEl.textContent = 'Bank ' + bankData[val].label;
                bankVaEl.textContent   = bankData[val].va;
                bankOwnerEl.textContent= bankData[val].owner;
                bankInfo.classList.remove('hidden');
            } else {
                bankInfo.classList.add('hidden');
            }
        });
    }
});
</script>

@endsection
