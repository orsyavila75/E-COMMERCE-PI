@extends('template.main-template')

@section('content')

    @php
        // Default product if not provided
        $product = $product ?? [
            'name' => 'Produk Contoh',
            'price' => 150000,
            'description' => 'Deskripsi produk',
            'image' => '',
            'stock' => 20,
            'rating' => 4.5,
            'seller' => 'Toko Contoh',
            'slug' => 'produk-contoh'
        ];
        $stock = $product['stock'] ?? 20;
    @endphp

    <div class="max-w-6xl mx-auto p-8 bg-white rounded-xl shadow-lg mt-8">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

            {{-- Bagian Kiri: Gambar dan Info Harga --}}
            <div class="flex flex-col items-center">

                <div class="w-full max-w-sm rounded-lg overflow-hidden border border-gray-200 shadow-md mb-6">
                    @php $imgFile = $product['image'] ?? ''; @endphp
                    <img src="{{ asset('images/' . rawurlencode(basename($imgFile))) }}"
                         alt="{{ $product['name'] }}"
                         class="w-full h-auto object-cover">
                </div>

                <div class="w-full max-w-sm text-center">
                    <h1 class="text-2xl font-bold text-gray-900 mb-1">{{ $product['name'] }}</h1>

                    <p class="text-3xl font-extrabold text-gray-800 mb-2">
                        Rp {{ number_format($product['price'], 0, ',', '.') }}
                    </p>

                    {{-- Rating + terjual --}}
                    <div class="flex items-center justify-center text-sm text-gray-500">
                        <svg class="w-4 h-4 mr-1 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.963a1 1 0 00.95.69h4.17c.969 0 1.371 1.24.588 1.81l-3.374 2.454a1 1 0 00-.364 1.118l1.286 3.963c.3.921-.755 1.688-1.54 1.118l-3.374-2.454a1 1 0 00-1.176 0l-3.374 2.454c-.784.57-1.84-.197-1.54-1.118l1.286-3.963a1 1 0 00-.364-1.118L2.091 9.39c-.783-.57-.381-1.81.588-1.81h4.17a1 1 0 00.95-.69l1.286-3.963z"></path>
                        </svg>
                        <span class="mr-3">4.8</span> |
                        <span class="ml-3">1,4RB Terjual</span>
                    </div>

                    {{-- Stok --}}
                    <div class="mt-2 text-sm text-gray-600">
                        Stok: <span id="stockValue" class="font-semibold">{{ $stock }}</span> pcs
                    </div>

                    {{-- Kontrol jumlah + / - --}}
                    <div class="mt-4 flex items-center justify-center gap-3">
                        <button id="qtyMinus"
                                class="w-8 h-8 flex items-center justify-center border border-gray-300 rounded-full text-lg font-bold text-gray-700 hover:bg-gray-100">
                            −
                        </button>
                        <span id="qtyDisplay" class="min-w-[2rem] text-lg font-semibold text-gray-900">1</span>
                        <button id="qtyPlus"
                                class="w-8 h-8 flex items-center justify-center border border-gray-300 rounded-full text-lg font-bold text-gray-700 hover:bg-gray-100">
                            +
                        </button>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="mt-6 space-y-3">
                        <button id="btnBuyNow"
                                class="w-full py-3 text-lg font-semibold text-white rounded-lg shadow-md hover:opacity-90 transition duration-200"
                                style="background-color: #934c26;">
                            Beli Sekarang
                        </button>

                        <form action="{{ route('cart.add') }}" method="POST" id="addToCartForm">
                            @csrf
                            <input type="hidden" name="slug" value="{{ $product['slug'] }}">
                            <input type="hidden" name="qty" id="inputQty" value="1">
                            <button type="submit"
                                    class="w-full py-3 text-lg font-semibold text-gray-800 rounded-lg border-2 border-gray-300 hover:bg-gray-100 transition duration-200">
                                + Keranjang
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Bagian Kanan: Deskripsi dan Spesifikasi --}}
            <div>
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Deskripsi</h2>
                <p class="text-gray-700 leading-relaxed mb-6">
                    Tambahkan sentuhan etnik yang elegan pada gaya harianmu dengan tas rotan bulat handmade ini! Dibuat
                    dengan tangan oleh pengrajin lokal, tas ini menggabungkan keindahan anyaman tradisional dan desain
                    modern yang unik.
                </p>

                <h3 class="text-2xl font-semibold text-gray-800 mb-3">Spesifikasi Produk:</h3>
                <ul class="list-none space-y-2 text-gray-700 mb-6 pl-0">
                    <li class="flex items-start">
                        <span class="text-xl mr-2">🧶</span>
                        <span><strong>Bahan:</strong> Rotan alami pilihan berkualitas tinggi</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-xl mr-2">🎨</span>
                        <span><strong>Warna:</strong> Cokelat alami dengan detail anyaman motif unik</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-xl mr-2">👜</span>
                        <span><strong>Model:</strong> Tas selempang bulat (round bag)</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-xl mr-2">📏</span>
                        <span><strong>Ukuran:</strong> Diameter sekitar 20 cm, ketebalan sekitar 7 cm</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-xl mr-2">🦋</span>
                        <span><strong>Lapisan dalam:</strong> Kain batik/kanvas lembut (warna dapat bervariasi)</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-xl mr-2">🔒</span>
                        <span><strong>Penutup:</strong> Kancing pengait kulit sintetis</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-xl mr-2">🎗️</span>
                        <span><strong>Tali:</strong> Tali kulit sintetis kuat dan nyaman dipakai</span>
                    </li>
                </ul>

                <h3 class="text-2xl font-semibold text-gray-800 mb-3">Kelebihan:</h3>
                <ul class="list-disc space-y-2 text-gray-700 pl-6">
                    <li>Ringan dan mudah dibawa</li>
                    <li>Cocok untuk outfit kasual maupun semi-formal</li>
                    <li>Handmade – setiap tas memiliki ciri khas tersendiri</li>
                    <li>Ramah lingkungan 🌿</li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Reviews Section --}}
    <div class="max-w-6xl mx-auto p-8 bg-white rounded-xl shadow-lg mt-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Ulasan Produk</h2>

        {{-- Review Form --}}
        @auth
            <div class="bg-gray-50 p-6 rounded-xl mb-8">
                <h3 class="font-semibold text-gray-900 mb-4">Tulis Ulasan</h3>
                <form action="{{ route('reviews.store') }}" method="POST">
                    @csrf
                    {{-- Dummy product ID for now since we use array in controller --}}
                    {{-- In real app, use $product->id_produk --}}
                    <input type="hidden" name="id_produk" value="1"> 
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                        <div class="flex gap-4">
                            @foreach(range(5, 1) as $rating)
                                <label class="cursor-pointer">
                                    <input type="radio" name="rating" value="{{ $rating }}" class="hidden peer" required>
                                    <span class="text-2xl text-gray-300 peer-checked:text-yellow-400 hover:text-yellow-400 transition-colors">★</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Komentar</label>
                        <textarea name="comment" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Bagaimana pengalamanmu dengan produk ini?"></textarea>
                    </div>

                    <button type="submit" class="px-6 py-2 bg-primary-600 text-white font-medium rounded-lg hover:bg-primary-700 transition-colors">
                        Kirim Ulasan
                    </button>
                </form>
            </div>
        @endauth

        {{-- Reviews List (Dummy Data for Display) --}}
        <div class="space-y-6">
            <div class="border-b border-gray-100 pb-6">
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center text-xs font-bold text-gray-600">A</div>
                    <span class="font-medium text-gray-900">Andi Saputra</span>
                    <span class="text-sm text-gray-500">• 2 hari yang lalu</span>
                </div>
                <div class="flex text-yellow-400 text-sm mb-2">★★★★★</div>
                <p class="text-gray-700">Barangnya bagus banget, sesuai ekspektasi. Pengiriman juga cepat.</p>
            </div>
            
            <div class="border-b border-gray-100 pb-6">
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center text-xs font-bold text-gray-600">S</div>
                    <span class="font-medium text-gray-900">Siti Aminah</span>
                    <span class="text-sm text-gray-500">• 1 minggu yang lalu</span>
                </div>
                <div class="flex text-yellow-400 text-sm mb-2">★★★★☆</div>
                <p class="text-gray-700">Kualitas anyaman rapi, tapi warnanya sedikit lebih gelap dari foto.</p>
            </div>
        </div>
    </div>

    {{-- Reviews Section --}}
    <div class="max-w-6xl mx-auto p-8 bg-white rounded-xl shadow-lg mt-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Ulasan Produk</h2>

        {{-- Review Form --}}
        @auth
            <div class="bg-gray-50 p-6 rounded-xl mb-8">
                <h3 class="font-semibold text-gray-900 mb-4">Tulis Ulasan</h3>
                <form action="{{ route('reviews.store') }}" method="POST">
                    @csrf
                    {{-- Dummy product ID for now since we use array in controller --}}
                    {{-- In real app, use $product->id_produk --}}
                    <input type="hidden" name="id_produk" value="1"> 
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                        <div class="flex gap-4">
                            @foreach(range(5, 1) as $rating)
                                <label class="cursor-pointer">
                                    <input type="radio" name="rating" value="{{ $rating }}" class="hidden peer" required>
                                    <span class="text-2xl text-gray-300 peer-checked:text-yellow-400 hover:text-yellow-400 transition-colors">★</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Komentar</label>
                        <textarea name="comment" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Bagaimana pengalamanmu dengan produk ini?"></textarea>
                    </div>

                    <button type="submit" class="px-6 py-2 bg-primary-600 text-white font-medium rounded-lg hover:bg-primary-700 transition-colors">
                        Kirim Ulasan
                    </button>
                </form>
            </div>
        @endauth

        {{-- Reviews List (Dummy Data for Display) --}}
        <div class="space-y-6">
            <div class="border-b border-gray-100 pb-6">
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center text-xs font-bold text-gray-600">A</div>
                    <span class="font-medium text-gray-900">Andi Saputra</span>
                    <span class="text-sm text-gray-500">• 2 hari yang lalu</span>
                </div>
                <div class="flex text-yellow-400 text-sm mb-2">★★★★★</div>
                <p class="text-gray-700">Barangnya bagus banget, sesuai ekspektasi. Pengiriman juga cepat.</p>
            </div>
            
            <div class="border-b border-gray-100 pb-6">
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center text-xs font-bold text-gray-600">S</div>
                    <span class="font-medium text-gray-900">Siti Aminah</span>
                    <span class="text-sm text-gray-500">• 1 minggu yang lalu</span>
                </div>
                <div class="flex text-yellow-400 text-sm mb-2">★★★★☆</div>
                <p class="text-gray-700">Kualitas anyaman rapi, tapi warnanya sedikit lebih gelap dari foto.</p>
            </div>
        </div>
    </div>

    {{-- Script untuk handle qty, stok, dan klik tombol --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const stock = {{ $stock }};   // stok maksimum
            let qty = 1;                  // jumlah awal

            // aman untuk dipakai di JS
            const productName = @json($product['name']);
            const productSlug = @json(\Illuminate\Support\Str::slug($product['name']));

            const qtyDisplay = document.getElementById('qtyDisplay');
            const btnPlus    = document.getElementById('qtyPlus');
            const btnMinus   = document.getElementById('qtyMinus');
            const btnCart    = document.getElementById('btnAddToCart');
            const btnBuyNow  = document.getElementById('btnBuyNow');

            function updateButtons() {
                btnMinus.disabled = qty <= 1;
                btnPlus.disabled  = qty >= stock;

                btnMinus.classList.toggle('opacity-50', qty <= 1);
                btnMinus.classList.toggle('cursor-not-allowed', qty <= 1);

                btnPlus.classList.toggle('opacity-50', qty >= stock);
                btnPlus.classList.toggle('cursor-not-allowed', qty >= stock);
            }

                if (qty < stock) {
                    qty++;
                    qtyDisplay.textContent = qty;
                    document.getElementById('inputQty').value = qty;
                    updateButtons();
                }
            });

                if (qty > 1) {
                    qty--;
                    qtyDisplay.textContent = qty;
                    document.getElementById('inputQty').value = qty;
                    updateButtons();
                }
            });

            // btnCart removed, using form submission

            // versi yang pakai slug ke /checkout
            btnBuyNow.addEventListener('click', function () {
                const url = "{{ route('checkout') }}" +
                    "?slug=" + encodeURIComponent(productSlug) +
                    "&qty=" + qty;

                window.location.href = url;
            });

            // set awal
            updateButtons();
        });
    </script>

@endsection
