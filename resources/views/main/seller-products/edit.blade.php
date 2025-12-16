@extends('template.seller-template')

@section('title', 'Edit Produk - Kerajinan Nusantara')
@section('page-title', 'Edit Produk')

@section('content')

{{-- Header with Gradient --}}
<div class="relative mb-8 rounded-2xl overflow-hidden bg-gradient-to-r from-primary-800 to-primary-900 p-8 text-white shadow-xl">
    <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-primary-500/20 rounded-full blur-2xl"></div>
    
    <div class="relative z-10">
        <nav class="flex items-center gap-2 text-sm text-primary-200 mb-3">
            <a href="{{ route('seller.dashboard') }}" class="hover:text-white transition-colors flex items-center gap-1">
                <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Dashboard
            </a>
            <i data-lucide="chevron-right" class="w-4 h-4"></i>
            <span class="text-white font-medium">Edit Produk</span>
        </nav>
        <h1 class="text-3xl font-bold mb-2 tracking-tight">Edit Produk</h1>
        <p class="text-primary-100 text-lg max-w-2xl">Perbarui informasi produk Anda agar tetap relevan dan menarik bagi pembeli.</p>
    </div>
</div>

<form action="{{ route('seller.products.update', $product->id_produk) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="grid lg:grid-cols-3 gap-8">
        {{-- Main Form Column --}}
        <div class="lg:col-span-2 space-y-8">
            
            {{-- Informasi Dasar Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-primary-100 overflow-hidden group hover:shadow-md transition-all duration-300">
                <div class="p-6 border-b border-primary-50 bg-primary-50/30 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-primary-100 flex items-center justify-center text-primary-600 group-hover:bg-primary-600 group-hover:text-white transition-colors duration-300">
                        <i data-lucide="package" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h2 class="font-bold text-primary-900 text-lg">Informasi Dasar</h2>
                        <p class="text-sm text-primary-500">Detail utama produk Anda</p>
                    </div>
                </div>
                <div class="p-8 space-y-6">
                    {{-- Nama Produk --}}
                    <div>
                        <label class="block text-sm font-semibold text-primary-700 mb-2">Nama Produk <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_produk" value="{{ old('nama_produk', $product->nama_produk) }}" required placeholder="Contoh: Tas Anyaman Pandan Premium"
                               class="w-full px-5 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all @error('nama_produk') border-red-500 bg-red-50 @enderror">
                        @error('nama_produk')
                            <p class="text-xs text-red-500 mt-1 flex items-center gap-1"><i data-lucide="alert-circle" class="w-3 h-3"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kategori & Berat --}}
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-primary-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select name="jenis_produk" required class="w-full px-5 py-3.5 bg-gray-50 border border-gray-200 rounded-xl appearance-none focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all @error('jenis_produk') border-red-500 @enderror">
                                    <option value="">Pilih Kategori</option>
                                    @foreach(['Anyaman', 'Ukiran', 'Batik', 'Rajutan', 'Keramik', 'Tenun'] as $cat)
                                        <option value="{{ $cat }}" {{ old('jenis_produk', $product->jenis_produk) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                    @endforeach
                                </select>
                                <i data-lucide="chevron-down" class="absolute right-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 pointer-events-none"></i>
                            </div>
                            @error('jenis_produk')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-primary-700 mb-2">Berat (gram)</label>
                            <div class="relative">
                                <input type="number" name="berat" value="{{ old('berat', $product->berat ?? '') }}" placeholder="500"
                                       class="w-full px-5 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all">
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-medium">gr</span>
                            </div>
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label class="block text-sm font-semibold text-primary-700 mb-2">Deskripsi Produk <span class="text-red-500">*</span></label>
                        <textarea name="deskripsi" rows="6" required placeholder="Ceritakan keunikan produk, bahan yang digunakan, dan detail ukurannya..."
                                  class="w-full px-5 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 resize-none transition-all @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi', $product->deskripsi) }}</textarea>
                        <div class="flex justify-between mt-2">
                            <p class="text-xs text-primary-400">Minimal 50 karakter agar pembeli lebih percaya.</p>
                            <p class="text-xs text-primary-400">0/2000</p>
                        </div>
                        @error('deskripsi')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Harga & Stok Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-primary-100 overflow-hidden group hover:shadow-md transition-all duration-300">
                <div class="p-6 border-b border-primary-50 bg-primary-50/30 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-primary-100 flex items-center justify-center text-primary-600 group-hover:bg-primary-600 group-hover:text-white transition-colors duration-300">
                        <i data-lucide="tag" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h2 class="font-bold text-primary-900 text-lg">Harga & Inventaris</h2>
                        <p class="text-sm text-primary-500">Atur harga jual dan ketersediaan stok</p>
                    </div>
                </div>
                <div class="p-8 space-y-6">
                    <div class="grid md:grid-cols-2 gap-6">
                        {{-- Harga --}}
                        <div>
                            <label class="block text-sm font-semibold text-primary-700 mb-2">Harga Satuan <span class="text-red-500">*</span></label>
                            <div class="relative group/input">
                                <div class="absolute left-0 top-0 bottom-0 w-12 bg-gray-50 border-y border-l border-gray-200 rounded-l-xl flex items-center justify-center text-primary-600 font-bold group-focus-within/input:border-primary-500 group-focus-within/input:bg-primary-50 group-focus-within/input:text-primary-700 transition-colors">Rp</div>
                                <input type="number" name="harga" value="{{ old('harga', $product->harga) }}" required placeholder="150000"
                                       class="w-full pl-16 pr-5 py-3.5 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all font-medium text-lg text-primary-900 @error('harga') border-red-500 @enderror">
                            </div>
                            @error('harga')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Stok --}}
                        <div>
                            <label class="block text-sm font-semibold text-primary-700 mb-2">Stok Tersedia <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="number" name="stok" value="{{ old('stok', $product->stok) }}" required placeholder="10" min="0"
                                       class="w-full px-5 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all @error('stok') border-red-500 @enderror">
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm">pcs</span>
                            </div>
                            @error('stok')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Diskon & SKU --}}
                    <div class="grid md:grid-cols-2 gap-6 pt-4 border-t border-dashed border-gray-200">
                        <div>
                            <label class="block text-sm font-semibold text-primary-700 mb-2">Diskon (Opsional)</label>
                            <div class="relative">
                                <input type="number" name="diskon" value="{{ old('diskon', $product->diskon ?? '') }}" placeholder="0" min="0" max="100"
                                       class="w-full px-5 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all">
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-bold">%</span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-primary-700 mb-2">SKU (Kode Unik)</label>
                            <input type="text" name="sku" value="{{ old('sku', $product->sku ?? '') }}" placeholder="PRD-001"
                                   class="w-full px-5 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all uppercase tracking-wider text-sm">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Product Images Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-primary-100 overflow-hidden group hover:shadow-md transition-all duration-300">
                <div class="p-6 border-b border-primary-50 bg-primary-50/30 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-primary-100 flex items-center justify-center text-primary-600 group-hover:bg-primary-600 group-hover:text-white transition-colors duration-300">
                        <i data-lucide="image" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h2 class="font-bold text-primary-900 text-lg">Foto Produk</h2>
                        <p class="text-sm text-primary-500">Update foto produk jika diperlukan</p>
                    </div>
                </div>
                <div class="p-8">
                    <div class="relative border-2 border-dashed border-primary-200 rounded-2xl p-10 text-center hover:border-primary-500 hover:bg-primary-50/50 transition-all duration-300 group/upload">
                        <input type="file" name="gambar" id="product-image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        
                        <div id="image-preview-container" class="{{ $product->gambar ? '' : 'hidden' }} mb-6 relative z-20 pointer-events-none">
                            <img id="image-preview" src="{{ $product->gambar ? asset('storage/' . $product->gambar) : '#' }}" alt="Preview" class="max-h-64 mx-auto rounded-xl shadow-lg object-cover">
                            <p class="text-sm text-primary-600 mt-4 font-medium">Klik atau drop file baru untuk mengganti</p>
                        </div>

                        <div id="upload-placeholder" class="{{ $product->gambar ? 'hidden' : '' }} transition-all duration-300 group-hover/upload:scale-105">
                            <div class="w-20 h-20 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-6 group-hover/upload:bg-primary-200 transition-colors">
                                <i data-lucide="cloud-upload" class="w-10 h-10 text-primary-600"></i>
                            </div>
                            <h3 class="font-bold text-primary-900 text-lg mb-2">Upload Foto Produk</h3>
                            <p class="text-primary-500 mb-1">Drag & drop file di sini atau klik untuk memilih</p>
                            <p class="text-xs text-primary-400">Format: PNG, JPG, JPEG (Maks. 2MB)</p>
                        </div>
                    </div>
                    @error('gambar')
                        <p class="text-xs text-red-500 mt-2 flex items-center gap-1 justify-center"><i data-lucide="alert-circle" class="w-3 h-3"></i> {{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Sidebar Column --}}
        <div class="space-y-8">
            {{-- Publish Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-primary-100 p-6 sticky top-24">
                <h3 class="font-bold text-primary-900 mb-6 flex items-center gap-2">
                    <i data-lucide="save" class="w-5 h-5 text-primary-600"></i> Simpan
                </h3>
                
                <div class="space-y-3">
                    <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-primary-600 to-primary-700 text-white font-bold rounded-xl hover:from-primary-700 hover:to-primary-800 transition-all shadow-lg shadow-primary-500/30 flex items-center justify-center gap-2 transform active:scale-[0.98]">
                        <i data-lucide="check-circle" class="w-5 h-5"></i>
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('seller.dashboard') }}" class="w-full py-3.5 bg-white border border-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-50 hover:text-gray-900 transition-all flex items-center justify-center gap-2">
                        <i data-lucide="x" class="w-4 h-4"></i>
                        Batal
                    </a>
                </div>
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
