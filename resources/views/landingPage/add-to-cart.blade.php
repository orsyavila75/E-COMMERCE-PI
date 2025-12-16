@extends('template.main-template')

@section('content')

    <div class="max-w-7xl mx-auto p-8">

        <h1 class="text-3xl font-bold text-gray-900 mb-8">Katalog Produk</h1>

        {{-- Grid Produk (Hanya 4 item yang terlihat di preview) --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 pb-10">

            {{-- Data Produk --}}
            @php
                $products = [
                    ['id' => 1, 'name' => 'Tas Kayu', 'stock' => 10, 'price' => 'Rp 150.000', 'rating' => 4.7, 'image' => 'tas_kayu.jpg'],
                    ['id' => 2, 'name' => 'Rak Buku', 'stock' => 5, 'price' => 'Rp 250.000', 'rating' => 4.7, 'image' => 'rak_buku.jpg'],
                    ['id' => 3, 'name' => 'Storage basket', 'stock' => 10, 'price' => 'Rp 120.000', 'rating' => 4.5, 'image' => 'storage_basket.jpg'],
                    ['id' => 4, 'name' => 'Meja Kayu', 'stock' => 5, 'price' => 'Rp 200.000', 'rating' => 4.8, 'image' => 'meja_kayu.jpg'],
                ];
            @endphp

            @foreach ($products as $product)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden transition transform hover:shadow-xl duration-300">
                    <img src="{{ asset('images/' . $product['image']) }}" alt="{{ $product['name'] }}" class="w-full h-40 object-cover p-3">
                    <div class="p-4">
                        <h3 class="font-medium text-gray-800 truncate">{{ $product['name'] }}</h3>
                        <p class="text-sm text-gray-600">Stok: {{ $product['stock'] }}</p>
                        <div class="flex items-center justify-between mt-1 mb-3">
                            <p class="text-lg font-bold text-gray-900">{{ $product['price'] }}</p>
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

        {{-- ======================================================== --}}
        {{-- BAGIAN MEMASUKKAN KERANJANG (Inline Section) --}}
        {{-- ======================================================== --}}
        <div id="cart-section" class="mt-16 bg-gray-100 p-8 rounded-xl shadow-inner max-w-4xl mx-auto">

            <a href="{{ route('products.page') }}" class="text-gray-600 hover:text-gray-900 flex items-center mb-6">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Katalog Produk
            </a>

            {{-- Detail Produk yang Dipilih (Meja Kayu) --}}
            <div class="flex flex-col md:flex-row items-start md:items-center space-y-4 md:space-y-0 md:space-x-8">

                {{-- Gambar Produk --}}
                <div class="flex-shrink-0">
                    <img src="{{ asset('images/meja_kayu_thumb.jpg') }}" alt="Meja Kayu" class="w-24 h-24 object-cover rounded-lg border border-gray-300">
                </div>

                {{-- Info dan Form --}}
                <div class="flex-grow space-y-3">
                    <p class="text-sm text-gray-600 font-semibold mb-1">Stok Tersedia: 5</p>

                    <h2 class="text-2xl font-bold text-gray-900">Meja Kayu</h2>
                    <p class="text-xl font-extrabold text-gray-800">Rp 200.000</p>

                    <p class="text-gray-700 font-medium pt-2">Deskripsi:</p>
                    <p class="text-sm text-gray-600 italic">
                        Meja kayu minimalis berbahan dasar kayu jati solid. Tahan lama dan cocok untuk ruang kerja atau ruang tamu dengan gaya natural.
                    </p>

                    <form action="{{ route('cart') }}" method="POST" class="mt-4">
                        @csrf
                        {{-- ID produk Meja Kayu --}}
                        <input type="hidden" name="product_id" value="4">

                        <label for="quantity" class="block text-gray-700 font-medium mb-2">Jumlah:</label>
                        <div class="flex items-center space-x-3">

                            {{-- Input Jumlah (Counter) --}}
                            <div class="flex items-center border border-gray-400 rounded-lg overflow-hidden w-36">
                                <button type="button" onclick="changeQuantity(-1)" class="p-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold">-</button>
                                <input type="number" id="quantity" name="quantity" value="1" min="1" max="5"
                                       class="w-full text-center p-2 border-x border-gray-400 focus:outline-none" readonly>
                                <button type="button" onclick="changeQuantity(1)" class="p-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold">+</button>
                            </div>

                            {{-- Tombol Tambah ke Keranjang --}}
                            <button type="submit"
                                    class="px-8 py-2 text-white font-medium rounded-lg shadow-md hover:opacity-90 transition duration-150"
                                    style="background-color: #a3a3a3;"> {{-- Warna Abu-abu terang sesuai preview --}}
                                Tambah Ke Keranjang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

@endsection

@push('scripts')
<script>
    function changeQuantity(change) {
        const input = document.getElementById('quantity');
        let currentValue = parseInt(input.value);
        const maxStock = parseInt(input.getAttribute('max'));

        let newValue = currentValue + change;

        if (newValue >= 1 && newValue <= maxStock) {
            input.value = newValue;
        }
    }
</script>
@endpush
