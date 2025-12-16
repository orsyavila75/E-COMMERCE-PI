@extends('template.main-template')

@section('title', 'Keranjang Belanja - Kerajinan Nusantara')

@section('content')

@php
    // Pastikan variabel selalu ada (dari CartController)
    $cartItems   = $cartItems ?? [];
    $totalQty    = $totalQty ?? 0;
    $totalPrice  = $totalPrice ?? 0;
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
            <span class="text-white">Keranjang</span>
        </nav>
        <h1 class="font-display text-3xl md:text-4xl font-bold text-white flex items-center gap-3">
            <i data-lucide="shopping-cart" class="w-8 h-8"></i>
            Keranjang Belanja
        </h1>
    </div>
</section>

{{-- Main Content --}}
<section class="py-8 bg-primary-50 min-h-screen">
    <div class="container mx-auto px-4">
        <div class="grid lg:grid-cols-3 gap-8">

            {{-- Cart Items --}}
            <div class="lg:col-span-2">
                @if(count($cartItems) > 0)
                    {{-- Select All --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-primary-100 p-4 mb-4">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" id="select-all" checked class="w-5 h-5 rounded border-primary-300 text-primary-600 focus:ring-primary-500">
                            <span class="font-medium text-primary-900">
                                Pilih Semua ({{ count($cartItems) }} produk)
                            </span>
                        </label>
                    </div>

                    {{-- Cart Items List --}}
                    <div class="space-y-4">
                        @foreach ($cartItems as $item)
                            @php
                                $slug   = $item['slug']  ?? '';
                                $name   = $item['name']  ?? 'Produk';
                                $price  = (int)($item['price'] ?? 0);
                                $qty    = (int)($item['qty']   ?? 1);
                                $image  = $item['image'] ?? null;
                                // stok dari session (bisa null kalau belum diset)
                                $stock  = isset($item['stock']) ? (int)$item['stock'] : null;
                                $seller = $item['seller'] ?? 'Penjual Kerajinan';
                                $rating = $item['rating'] ?? 5;
                            @endphp

                            <div class="bg-white rounded-2xl shadow-sm border border-primary-100 p-5 cart-item" data-slug="{{ $slug }}">
                                <div class="flex gap-4">
                                    {{-- Checkbox --}}
                                    <div class="flex items-start pt-1">
                                        <input type="checkbox" name="selected_items[]" value="{{ $slug }}"
                                               checked
                                               class="item-checkbox w-5 h-5 rounded border-primary-300 text-primary-600 focus:ring-primary-500">
                                    </div>

                                    {{-- Image --}}
                                    <div class="flex-shrink-0">
                                        @php
                                            $fallbackImage = 'https://images.unsplash.com/photo-1590874103328-eac38a683ce7?w=200&h=200&fit=crop';
                                            $src = $image ? asset('images/' . rawurlencode(basename($image))) : $fallbackImage;
                                        @endphp
                                        <img src="{{ $src }}" alt="{{ $name }}"
                                             class="w-24 h-24 md:w-28 md:h-28 object-cover rounded-xl">
                                    </div>

                                    {{-- Details --}}
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-start justify-between gap-4">
                                            <div>
                                                <h3 class="font-semibold text-primary-900 mb-1">
                                                    {{ $name }}
                                                </h3>
                                                <p class="text-sm text-primary-500 mb-2">
                                                    {{ $seller }}
                                                </p>
                                                <div class="flex items-center gap-1 mb-2">
                                                    @for($i = 0; $i < $rating; $i++)
                                                        <i data-lucide="star" class="w-4 h-4 fill-amber-400 text-amber-400"></i>
                                                    @endfor
                                                </div>
                                            </div>

                                            {{-- Tombol hapus -> panggil route cart.remove (hapus dari session) --}}
                                            <a href="{{ route('cart.remove', ['slug' => $slug]) }}"
                                               class="p-2 text-primary-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors"
                                               onclick="return confirm('Hapus produk ini dari keranjang?')">
                                                <i data-lucide="trash-2" class="w-5 h-5"></i>
                                            </a>
                                        </div>

                                        <div class="flex items-end justify-between mt-3">
                                            <div class="flex items-center gap-3">
                                                <div class="flex items-center border border-primary-200 rounded-lg">
                                                    <button type="button"
                                                            class="qty-btn minus w-9 h-9 flex items-center justify-center text-primary-600 hover:bg-primary-50 rounded-l-lg transition-colors">
                                                        <i data-lucide="minus" class="w-4 h-4"></i>
                                                    </button>
                                                    <input type="number"
                                                           value="{{ $qty }}"
                                                           min="1"
                                                           max="{{ $stock ?? 99 }}"
                                                           data-price="{{ $price }}"
                                                           class="quantity-input w-12 h-9 text-center border-x border-primary-200 text-primary-900 font-medium focus:outline-none">
                                                    <button type="button"
                                                            class="qty-btn plus w-9 h-9 flex items-center justify-center text-primary-600 hover:bg-primary-50 rounded-r-lg transition-colors">
                                                        <i data-lucide="plus" class="w-4 h-4"></i>
                                                    </button>
                                                </div>
                                                <span class="text-sm text-primary-500">
                                                    Stok: {{ $stock !== null ? $stock : '-' }}
                                                </span>
                                            </div>
                                            <p class="text-lg font-bold text-primary-700">
                                                Rp {{ number_format($price, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    {{-- Empty Cart State --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-primary-100 p-12 text-center">
                        <div class="w-20 h-20 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i data-lucide="shopping-cart" class="w-10 h-10 text-primary-400"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-primary-900 mb-2">Keranjang Kosong</h3>
                        <p class="text-primary-500 mb-6">Belum ada produk di keranjang Anda</p>
                        <a href="{{ route('products.page') }}"
                           class="inline-flex items-center gap-2 px-6 py-3 bg-primary-600 text-white font-medium rounded-xl hover:bg-primary-700 transition-colors">
                            <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                            Mulai Belanja
                        </a>
                    </div>
                @endif
            </div>

            {{-- Order Summary --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-primary-100 p-6 sticky top-24">
                    <h2 class="font-semibold text-lg text-primary-900 mb-6 flex items-center gap-2">
                        <i data-lucide="receipt" class="w-5 h-5 text-primary-600"></i>
                        Ringkasan Belanja
                    </h2>

                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between text-primary-600">
                            <span>Total Harga (<span id="item-count">{{ $totalQty }}</span> barang)</span>
                            <span id="subtotal">
                                Rp {{ number_format($totalPrice, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="flex justify-between text-primary-600">
                            <span>Diskon</span>
                            <span class="text-green-600">- Rp 0</span>
                        </div>
                        <div class="border-t border-primary-200 pt-4">
                            <div class="flex justify-between">
                                <span class="font-semibold text-primary-900">Total</span>
                                <span id="total-price" class="text-xl font-bold text-primary-700">
                                    Rp {{ number_format($totalPrice, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Promo Code --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-primary-700 mb-2">Kode Promo</label>
                        <div class="flex gap-2">
                            <input type="text" placeholder="Masukkan kode"
                                   class="flex-1 px-4 py-2.5 border border-primary-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                            <button class="px-4 py-2.5 bg-primary-100 text-primary-700 font-medium rounded-xl hover:bg-primary-200 transition-colors text-sm">
                                Terapkan
                            </button>
                        </div>
                    </div>

                    {{-- Checkout Button --}}
                    <a href="{{ route('checkout') }}"
                       class="btn-shine w-full py-4 bg-gradient-to-r from-primary-600 to-primary-700 text-white font-semibold rounded-xl hover:from-primary-700 hover:to-primary-800 transition-all shadow-lg shadow-primary-500/30 flex items-center justify-center gap-2">
                        <i data-lucide="credit-card" class="w-5 h-5"></i>
                        Checkout Sekarang
                    </a>

                    {{-- Continue Shopping --}}
                    <a href="{{ route('products.page') }}"
                       class="mt-4 w-full py-3 border border-primary-200 text-primary-700 font-medium rounded-xl hover:bg-primary-50 transition-colors flex items-center justify-center gap-2">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i>
                        Lanjut Belanja
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const formatRupiah = (number) => {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(number);
    };

    function updateTotal() {
        let total = 0;
        let itemCount = 0;
        const items = document.querySelectorAll('.cart-item');

        items.forEach(item => {
            const checkbox = item.querySelector('.item-checkbox');
            const qtyInput = item.querySelector('.quantity-input');

            if (checkbox && checkbox.checked && qtyInput) {
                const price = parseFloat(qtyInput.dataset.price);
                const qty   = parseInt(qtyInput.value);
                total      += price * qty;
                itemCount  += qty;
            }
        });

        const totalPriceEl = document.getElementById('total-price');
        const subtotalEl   = document.getElementById('subtotal');
        const itemCountEl  = document.getElementById('item-count');

        if (totalPriceEl) totalPriceEl.textContent = formatRupiah(total);
        if (subtotalEl)   subtotalEl.textContent   = formatRupiah(total);
        if (itemCountEl)  itemCountEl.textContent  = itemCount;

        // Sync select all checkbox
        const allCheckboxes = document.querySelectorAll('.item-checkbox');
        const selectAll = document.getElementById('select-all');
        if (selectAll && allCheckboxes.length > 0) {
            selectAll.checked = Array.from(allCheckboxes).every(cb => cb.checked);
        }
    }

    // Select all functionality
    const selectAllEl = document.getElementById('select-all');
    if (selectAllEl) {
        selectAllEl.addEventListener('change', function() {
            document.querySelectorAll('.item-checkbox').forEach(cb => cb.checked = this.checked);
            updateTotal();
        });
    }

    // Individual checkbox change
    document.querySelectorAll('.item-checkbox').forEach(cb => {
        cb.addEventListener('change', updateTotal);
    });

    // Quantity buttons
    document.querySelectorAll('.qty-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.parentElement.querySelector('.quantity-input');
            let value = parseInt(input.value);
            const max = parseInt(input.max);

            if (this.classList.contains('minus') && value > 1) {
                input.value = value - 1;
            } else if (this.classList.contains('plus') && value < max) {
                input.value = value + 1;
            }
            updateTotal();
        });
    });

    // Quantity input change
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            const max = parseInt(this.max);
            const min = 1;
            let value = parseInt(this.value);

            if (value < min) this.value = min;
            if (value > max) this.value = max;
            updateTotal();
        });
    });

    updateTotal();
});
</script>

@endsection
