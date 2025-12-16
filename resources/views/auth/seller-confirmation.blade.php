@extends('template.main-template')

@section('title', 'Daftar Jadi Seller - Kerajinan Nusantara')

@section('content')

{{-- Hero Banner --}}
<section class="bg-gradient-to-r from-primary-800 to-primary-900 py-16 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 right-0 w-96 h-96 bg-white rounded-full blur-3xl"></div>
    </div>
    <div class="container mx-auto px-4 relative z-10 text-center">
        <div class="w-20 h-20 bg-white/10 rounded-2xl flex items-center justify-center backdrop-blur-sm mx-auto mb-6">
            <i data-lucide="store" class="w-10 h-10 text-white"></i>
        </div>
        <h1 class="font-display text-4xl md:text-5xl font-bold text-white mb-4">
            Mulai Berjualan
        </h1>
        <p class="text-primary-200 text-lg max-w-2xl mx-auto">
            Upgrade akun Anda menjadi Seller dan mulai jual kerajinan tangan Anda ke seluruh Indonesia
        </p>
    </div>
</section>

{{-- Main Content --}}
<section class="py-12 bg-primary-50">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            
            {{-- Benefits --}}
            <div class="grid md:grid-cols-3 gap-6 mb-12">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-primary-100 text-center">
                    <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="trending-up" class="w-7 h-7 text-green-600"></i>
                    </div>
                    <h3 class="font-semibold text-primary-900 mb-2">Jangkauan Luas</h3>
                    <p class="text-sm text-primary-500">Jual produk ke ribuan pembeli di seluruh Indonesia</p>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-primary-100 text-center">
                    <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="shield-check" class="w-7 h-7 text-blue-600"></i>
                    </div>
                    <h3 class="font-semibold text-primary-900 mb-2">Transaksi Aman</h3>
                    <p class="text-sm text-primary-500">Pembayaran dijamin aman dengan sistem escrow</p>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-primary-100 text-center">
                    <div class="w-14 h-14 bg-amber-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="headphones" class="w-7 h-7 text-amber-600"></i>
                    </div>
                    <h3 class="font-semibold text-primary-900 mb-2">Dukungan 24/7</h3>
                    <p class="text-sm text-primary-500">Tim support siap membantu kapan saja</p>
                </div>
            </div>

            {{-- Registration Form --}}
            <div class="bg-white rounded-2xl shadow-sm border border-primary-100 overflow-hidden">
                <div class="p-6 border-b border-primary-100 bg-gradient-to-r from-primary-600 to-primary-700">
                    <h2 class="text-xl font-semibold text-white flex items-center gap-2">
                        <i data-lucide="clipboard-list" class="w-6 h-6"></i>
                        Formulir Pendaftaran Seller
                    </h2>
                    <p class="text-primary-100 text-sm mt-1">Lengkapi data toko Anda untuk memulai</p>
                </div>
                
                <form action="{{ route('seller.register') }}" method="POST" class="p-8">
                    @csrf
                    
                    <div class="space-y-6">
                        {{-- Store Info --}}
                        <div>
                            <h3 class="font-medium text-primary-900 mb-4 flex items-center gap-2">
                                <span class="w-6 h-6 bg-primary-600 text-white rounded-full flex items-center justify-center text-sm">1</span>
                                Informasi Toko
                            </h3>
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-primary-700 mb-2">Nama Toko <span class="text-red-500">*</span></label>
                                    <input type="text" name="nama_toko" required placeholder="Contoh: Galeri Anyaman Nusantara"
                                           class="w-full px-4 py-3 border border-primary-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-primary-700 mb-2">Kategori Produk <span class="text-red-500">*</span></label>
                                    <select name="kategori" required class="w-full px-4 py-3 border border-primary-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                                        <option value="">Pilih Kategori</option>
                                        <option value="Anyaman">Anyaman</option>
                                        <option value="Ukiran">Ukiran</option>
                                        <option value="Batik">Batik</option>
                                        <option value="Rajutan">Rajutan</option>
                                        <option value="Keramik">Keramik</option>
                                        <option value="Tenun">Tenun</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-primary-700 mb-2">Deskripsi Toko <span class="text-red-500">*</span></label>
                            <textarea name="deskripsi" rows="4" required placeholder="Ceritakan tentang toko dan produk kerajinan Anda..."
                                      class="w-full px-4 py-3 border border-primary-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 resize-none"></textarea>
                        </div>

                        {{-- Address --}}
                        <div>
                            <h3 class="font-medium text-primary-900 mb-4 flex items-center gap-2">
                                <span class="w-6 h-6 bg-primary-600 text-white rounded-full flex items-center justify-center text-sm">2</span>
                                Alamat Pengiriman
                            </h3>
                            <div>
                                <label class="block text-sm font-medium text-primary-700 mb-2">Alamat Lengkap <span class="text-red-500">*</span></label>
                                <textarea name="alamat" rows="3" required placeholder="Alamat lengkap untuk pengiriman produk"
                                          class="w-full px-4 py-3 border border-primary-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 resize-none">{{ Auth::user()->alamat ?? '' }}</textarea>
                            </div>
                        </div>

                        {{-- Agreement --}}
                        <div class="bg-primary-50 rounded-xl p-4">
                            <label class="flex items-start gap-3 cursor-pointer">
                                <input type="checkbox" name="agreement" required class="w-5 h-5 mt-0.5 text-primary-600 rounded focus:ring-primary-500">
                                <span class="text-sm text-primary-700">
                                    Saya menyetujui <a href="#" class="text-primary-600 underline">Syarat & Ketentuan</a> serta 
                                    <a href="#" class="text-primary-600 underline">Kebijakan Privasi</a> sebagai Seller di Kerajinan Nusantara.
                                </span>
                            </label>
                        </div>

                        {{-- Submit --}}
                        <div class="flex flex-col sm:flex-row gap-4">
                            <button type="submit" class="flex-1 py-3 bg-gradient-to-r from-primary-600 to-primary-700 text-white font-semibold rounded-xl hover:from-primary-700 hover:to-primary-800 transition-all shadow-lg shadow-primary-500/30 flex items-center justify-center gap-2">
                                <i data-lucide="send" class="w-5 h-5"></i>
                                Ajukan Pendaftaran
                            </button>
                            <a href="{{ route('customer.dashboard') }}" class="flex-1 py-3 border border-primary-200 text-primary-700 font-medium rounded-xl hover:bg-primary-50 transition-colors flex items-center justify-center gap-2">
                                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                                Kembali
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Info --}}
            <div class="mt-8 bg-blue-50 border border-blue-200 rounded-xl p-6">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i data-lucide="info" class="w-5 h-5 text-blue-600"></i>
                    </div>
                    <div>
                        <h4 class="font-medium text-blue-900 mb-1">Proses Verifikasi</h4>
                        <p class="text-sm text-blue-700">
                            Setelah mengajukan pendaftaran, tim kami akan memverifikasi data Anda dalam 1-3 hari kerja. 
                            Anda akan menerima notifikasi melalui email setelah proses selesai.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
