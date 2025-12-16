@extends('template.main-template')

@section('content')

    <div class="max-w-7xl mx-auto p-6">
        <h1 class="text-3xl font-semibold text-gray-900 mb-2">Hapus Produk</h1>
        <p class="text-xl text-gray-600 mb-8">Kelola produk kerajinan tangan lokal Anda</p>

        {{-- Form untuk Aksi Penghapusan Massal --}}
        <form id="delete-form" action="#" method="POST">
            @csrf
            @method('DELETE')

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                {{-- Contoh Data Produk (Dalam kasus nyata, ini adalah loop dari database) --}}
                @php
                    $products = [
                        ['id' => 1, 'name' => 'Tas Rotan', 'stock' => 20, 'price' => 'Rp 50.000', 'rating' => 4.8, 'image' => 'tas_rotan.jpg'],
                        ['id' => 2, 'name' => 'Rak Buku', 'stock' => 5, 'price' => 'Rp 250.000', 'rating' => 4.7, 'image' => 'rak_buku.jpg'],
                        ['id' => 3, 'name' => 'Storage Basket', 'stock' => 10, 'price' => 'Rp 120.000', 'rating' => 4.5, 'image' => 'storage_basket.jpg'],
                        ['id' => 4, 'name' => 'Craft Lamp', 'stock' => 3, 'price' => 'Rp 100.000', 'rating' => 4.6, 'image' => 'craft_lamp.jpg'],
                        ['id' => 5, 'name' => 'Tas Kayu', 'stock' => 13, 'price' => 'Rp 150.000', 'rating' => 4.7, 'image' => 'tas_kayu.jpg'],
                        ['id' => 6, 'name' => 'Kotak Tisu', 'stock' => 2, 'price' => 'Rp 25.000', 'rating' => 4.8, 'image' => 'kotak_tisu.jpg'],
                        ['id' => 7, 'name' => 'Vas Rotan', 'stock' => 15, 'price' => 'Rp 100.000', 'rating' => 4.8, 'image' => 'vas_rotan.jpg'],
                        ['id' => 8, 'name' => 'Bingkai Foto', 'stock' => 19, 'price' => 'Rp 25.000', 'rating' => 4.4, 'image' => 'bingkai_foto.jpg'],
                    ];
                @endphp

                @foreach ($products as $product)
                    <div class="relative bg-white rounded-lg shadow-md overflow-hidden border-2 border-transparent transition duration-200 product-card">

                        {{-- Checkbox Pemilihan --}}
                        <input type="checkbox" name="product_ids[]" value="{{ $product['id'] }}" class="absolute top-2 right-2 w-6 h-6 z-10 opacity-0 cursor-pointer product-checkbox">

                        {{-- Ikon Centang (Visual) --}}
                        <div class="absolute top-2 right-2 w-6 h-6 z-0 rounded-full bg-white border border-gray-300 flex items-center justify-center transition duration-200 checkmark">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>

                        <img src="{{ asset('images/' . rawurlencode(basename($product['image']))) }}" alt="{{ $product['name'] }}" class="w-full h-40 object-cover">
                        <div class="p-4">
                            <h3 class="font-medium text-gray-800">{{ $product['name'] }}</h3>
                            <p class="text-sm text-gray-600">Stok: {{ $product['stock'] }}</p>
                            <div class="flex justify-between items-center mt-1 mb-3">
                                <p class="text-sm font-semibold text-gray-900">{{ $product['price'] }}</p>
                                <span class="text-xs text-gray-600 flex items-center">
                                    <svg class="w-4 h-4 text-yellow-500 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.963a1 1 0 00.95.69h4.17c.969 0 1.371 1.24.588 1.81l-3.374 2.454a1 1 0 00-.364 1.118l1.286 3.963c.3.921-.755 1.688-1.54 1.118l-3.374-2.454a1 1 0 00-1.176 0l-3.374 2.454c-.784.57-1.84-.197-1.54-1.118l1.286-3.963a1 1 0 00-.364-1.118L2.091 9.39c-.783-.57-.381-1.81.588-1.81h4.17a1 1 0 00.95-.69l1.286-3.963z"></path></svg>
                                    {{ $product['rating'] }}
                                </span>
                            </div>
                            <a href="#" class="w-full inline-block text-center py-2 text-sm text-white font-medium rounded-md shadow-sm" style="background-color: #934c26;">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Floating Bottom Bar --}}
            <div id="action-bar" class="fixed bottom-0 left-1/2 transform -translate-x-1/2 p-4 rounded-t-xl shadow-2xl transition-all duration-300 opacity-0 pointer-events-none z-50"
                 style="background-color: #fbeedc; border-top: 2px solid #934c26;">

                <div class="flex items-center space-x-6">
                    <span id="selected-count" class="text-gray-800 font-semibold">0 Produk dipilih</span>

                    <button type="button" id="cancel-selection" class="px-5 py-2 text-gray-700 font-medium rounded-lg border border-gray-400 hover:bg-gray-200 transition duration-150">
                        Batal
                    </button>

                    <button type="submit" class="flex items-center px-6 py-2 text-white font-medium rounded-lg shadow-lg hover:opacity-90 transition duration-150"
                            style="background-color: #dc3545;"> {{-- Warna Merah untuk Hapus --}}
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Hapus Produk
                    </button>
                </div>
            </div>

        </form>
    </div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('.product-checkbox');
    const actionBar = document.getElementById('action-bar');
    const selectedCountSpan = document.getElementById('selected-count');
    const cancelButton = document.getElementById('cancel-selection');
    const productCards = document.querySelectorAll('.product-card');

    function updateActionBar() {
        let count = 0;
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                count++;
            }
        });

        selectedCountSpan.textContent = `${count} Produk dipilih`;

        if (count > 0) {
            actionBar.classList.remove('opacity-0', 'pointer-events-none');
        } else {
            actionBar.classList.add('opacity-0', 'pointer-events-none');
        }
    }

    // Event listener untuk setiap checkbox
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            const card = this.closest('.product-card');
            if (this.checked) {
                card.classList.add('border-red-400', 'shadow-xl'); // Efek visual saat terpilih
                card.querySelector('.checkmark').classList.add('bg-red-500', 'border-red-500');
            } else {
                card.classList.remove('border-red-400', 'shadow-xl');
                card.querySelector('.checkmark').classList.remove('bg-red-500', 'border-red-500');
            }
            updateActionBar();
        });
    });

    // Event listener untuk membatalkan pilihan
    cancelButton.addEventListener('click', function () {
        checkboxes.forEach(checkbox => {
            checkbox.checked = false;
            checkbox.dispatchEvent(new Event('change')); // Memicu perubahan visual
        });
        updateActionBar();
    });

    // Inisialisasi visual saat memuat
    updateActionBar();
});
</script>
@endpush
