{{-- resources/views/main/add-product.blade.php --}}
@extends('template.seller-template')

@section('title', 'Tambah Produk - Kerajinan Nusantara')
@section('page-title', 'Tambah Produk')

@section('content')

{{-- Header --}}
<div class="mb-8">
    <nav class="flex items-center gap-2 text-sm text-primary-500 mb-2">
        <a href="{{ route('seller.dashboard') }}" class="hover:text-primary-700">Dashboard</a>
        <i data-lucide="chevron-right" class="w-4 h-4"></i>
        <span class="text-primary-900">Tambah Produk</span>
    </nav>
    <h1 class="text-2xl font-bold text-primary-900">Tambah Produk Baru</h1>
    <p class="text-primary-500 mt-1">Lengkapi informasi produk kerajinan Anda</p>
</div>

<form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="grid lg:grid-cols-3 gap-8">
        {{-- Main Form --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Basic Info --}}
            <div class="bg-white rounded-2xl shadow-sm border border-primary-100 overflow-hidden">
                <div class="p-6 border-b border-primary-100">
                    <h2 class="font-semibold text-primary-900 flex items-center gap-2">
                        <i data-lucide="info" class="w-5 h-5 text-primary-600"></i>
                        Informasi Dasar
                    </h2>
                </div>
                <div class="p-6 space-y-5">
                    {{-- Nama Produk --}}
                    <div>
                        <label class="block text-sm font-medium text-primary-700 mb-2">Nama Produk <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_produk" value="{{ old('nama_produk') }}" required placeholder="Contoh: Tas Anyaman Pandan Premium"
                               class="w-full px-4 py-3 border border-primary-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 @error('nama_produk') border-red-500 @enderror">
                        @error('nama_produk')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kategori & Jenis --}}
                    <div class="grid md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-primary-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                            <select name="jenis_produk" required class="w-full px-4 py-3 border border-primary-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 @error('jenis_produk') border-red-500 @enderror">
                                <option value="">Pilih Kategori</option>
                                @foreach(['Anyaman', 'Ukiran', 'Batik', 'Rajutan', 'Keramik', 'Tenun'] as $cat)
                                    <option value="{{ $cat }}" {{ old('jenis_produk') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                            @error('jenis_produk')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-primary-700 mb-2">Berat (gram)</label>
                            <input type="number" name="berat" placeholder="500"
                                   class="w-full px-4 py-3 border border-primary-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label class="block text-sm font-medium text-primary-700 mb-2">Deskripsi Produk <span class="text-red-500">*</span></label>
                        <textarea name="deskripsi" rows="5" required placeholder="Jelaskan detail produk, bahan, ukuran, dan keunikan produk Anda..."
                                  class="w-full px-4 py-3 border border-primary-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 resize-none @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi') }}</textarea>
                        <p class="text-xs text-primary-400 mt-1">Minimal 50 karakter</p>
                        @error('deskripsi')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Pricing & Stock --}}
            <div class="bg-white rounded-2xl shadow-sm border border-primary-100 overflow-hidden">
                <div class="p-6 border-b border-primary-100">
                    <h2 class="font-semibold text-primary-900 flex items-center gap-2">
                        <i data-lucide="tag" class="w-5 h-5 text-primary-600"></i>
                        Harga & Stok
                    </h2>
                </div>
                <div class="p-6 space-y-5">
                    <div class="grid md:grid-cols-2 gap-5">
                        {{-- Harga --}}
                        <div>
                            <label class="block text-sm font-medium text-primary-700 mb-2">Harga (Rp) <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-primary-400">Rp</span>
                                <input type="number" name="harga" value="{{ old('harga') }}" required placeholder="150000"
                                       class="w-full pl-12 pr-4 py-3 border border-primary-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 @error('harga') border-red-500 @enderror">
                            </div>
                            @error('harga')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                            </div>
                        </div>

                        {{-- Stok --}}
                        <div>
                            <label class="block text-sm font-medium text-primary-700 mb-2">Stok <span class="text-red-500">*</span></label>
                            <input type="number" name="stok" value="{{ old('stok') }}" required placeholder="10" min="1"
                                   class="w-full px-4 py-3 border border-primary-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 @error('stok') border-red-500 @enderror">
                            @error('stok')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Diskon --}}
                    <div class="grid md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-primary-700 mb-2">Diskon (%)</label>
                            <input type="number" name="diskon" placeholder="0" min="0" max="100"
                                   class="w-full px-4 py-3 border border-primary-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-primary-700 mb-2">SKU (Opsional)</label>
                            <input type="text" name="sku" placeholder="PRD-001"
                                   class="w-full px-4 py-3 border border-primary-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Product Images --}}
            <div class="bg-white rounded-2xl shadow-sm border border-primary-100 overflow-hidden">
                <div class="p-6 border-b border-primary-100">
                    <h2 class="font-semibold text-primary-900 flex items-center gap-2">
                        <i data-lucide="image" class="w-5 h-5 text-primary-600"></i>
                        Foto Produk
                    </h2>
                </div>
                <div class="p-6">
                    <div class="border-2 border-dashed border-primary-200 rounded-xl p-8 text-center hover:border-primary-400 transition-colors">
                        <input type="file" name="gambar" id="product-image" accept="image/*" class="hidden">
                        <label for="product-image" class="cursor-pointer block">
                            <div id="image-preview-container" class="hidden mb-4">
                                <img id="image-preview" src="#" alt="Preview" class="max-h-48 mx-auto rounded-lg shadow-sm">
                            </div>
                            <div id="upload-placeholder">
                                <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i data-lucide="upload" class="w-8 h-8 text-primary-600"></i>
                                </div>
                                <p class="font-medium text-primary-900 mb-1">Klik untuk upload foto</p>
                                <p class="text-sm text-primary-500">atau drag & drop file di sini</p>
                                <p class="text-xs text-primary-400 mt-2">PNG, JPG, JPEG (Maks. 2MB)</p>
                            </div>
                        </label>
                        @error('gambar')
                            <p class="text-xs text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <p class="text-xs text-primary-500 mt-3">
                        <i data-lucide="info" class="w-3 h-3 inline"></i>
                        Tips: Gunakan foto dengan pencahayaan baik dan background polos
                    </p>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Publish Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-primary-100 p-6">
                <h3 class="font-semibold text-primary-900 mb-4">Publikasi</h3>
                <div class="space-y-4">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="radio" name="status" value="active" checked class="w-4 h-4 text-primary-600 focus:ring-primary-500">
                        <div>
                            <p class="font-medium text-primary-900">Aktif</p>
                            <p class="text-xs text-primary-500">Produk langsung tampil di toko</p>
                        </div>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="radio" name="status" value="draft" class="w-4 h-4 text-primary-600 focus:ring-primary-500">
                        <div>
                            <p class="font-medium text-primary-900">Draft</p>
                            <p class="text-xs text-primary-500">Simpan sebagai draft</p>
                        </div>
                    </label>
                </div>

                <div class="mt-6 space-y-3">
                    <button type="submit" class="w-full py-3 bg-gradient-to-r from-primary-600 to-primary-700 text-white font-semibold rounded-xl hover:from-primary-700 hover:to-primary-800 transition-all shadow-lg shadow-primary-500/30 flex items-center justify-center gap-2">
                        <i data-lucide="check" class="w-5 h-5"></i>
                        Simpan Produk
                    </button>
                    <a href="{{ route('seller.dashboard') }}" class="w-full py-3 border border-primary-200 text-primary-700 font-medium rounded-xl hover:bg-primary-50 transition-colors flex items-center justify-center gap-2">
                        <i data-lucide="x" class="w-4 h-4"></i>
                        Batal
                    </a>
                </div>
            </div>

            {{-- Tips Card --}}
            <div class="bg-gradient-to-br from-primary-50 to-primary-100 rounded-2xl p-6 border border-primary-200">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-primary-600 rounded-xl flex items-center justify-center">
                        <i data-lucide="lightbulb" class="w-5 h-5 text-white"></i>
                    </div>
                    <h3 class="font-semibold text-primary-900">Tips Jualan</h3>
                </div>
                <ul class="space-y-3 text-sm text-primary-700">
                    <li class="flex items-start gap-2">
                        <i data-lucide="check-circle" class="w-4 h-4 text-green-600 mt-0.5 flex-shrink-0"></i>
                        Gunakan nama produk yang jelas dan deskriptif
                    </li>
                    <li class="flex items-start gap-2">
                        <i data-lucide="check-circle" class="w-4 h-4 text-green-600 mt-0.5 flex-shrink-0"></i>
                        Upload foto berkualitas tinggi dari berbagai sudut
                    </li>
                    <li class="flex items-start gap-2">
                        <i data-lucide="check-circle" class="w-4 h-4 text-green-600 mt-0.5 flex-shrink-0"></i>
                        Tulis deskripsi lengkap termasuk ukuran dan bahan
                    </li>
                    <li class="flex items-start gap-2">
                        <i data-lucide="check-circle" class="w-4 h-4 text-green-600 mt-0.5 flex-shrink-0"></i>
                        Tetapkan harga kompetitif sesuai kualitas
                    </li>
                </ul>
            </div>
        </div>
    </div>
</form>

<script>
    document.getElementById('product-image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('image-preview').src = e.target.result;
                document.getElementById('image-preview-container').classList.remove('hidden');
                document.getElementById('upload-placeholder').classList.add('hidden');
            }
            reader.readAsDataURL(file);
        }
    });
</script>

@endsection
