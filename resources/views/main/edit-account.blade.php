{{-- resources/views/main/edit-account.blade.php --}}
@extends('template.seller-template')

@section('title', 'Pengaturan Toko - Kerajinan Nusantara')
@section('page-title', 'Pengaturan Toko')

@section('content')

{{-- Header --}}
{{-- Header --}}
<div class="bg-gradient-to-r from-primary-700 to-primary-900 rounded-2xl p-6 mb-8 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white rounded-full blur-3xl"></div>
    </div>
    <div class="relative z-10">
        <nav class="flex items-center gap-2 text-sm text-primary-200 mb-2">
            <a href="{{ route('seller.dashboard') }}" class="hover:text-white transition-colors">Dashboard</a>
            <i data-lucide="chevron-right" class="w-4 h-4"></i>
            <span class="text-white">Pengaturan</span>
        </nav>
        <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">Pengaturan Toko</h1>
        <p class="text-primary-100">Kelola informasi toko, akun, dan keamanan Anda.</p>
    </div>
</div>

<div class="grid lg:grid-cols-4 gap-8">
    {{-- Sidebar Navigation --}}
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl shadow-sm border border-primary-100 p-4 sticky top-24">
            <nav class="space-y-1">
                <a href="#profil" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-primary-100 text-primary-700 font-medium">
                    <i data-lucide="user" class="w-5 h-5"></i>
                    Profil Toko
                </a>
                <a href="#akun" class="flex items-center gap-3 px-4 py-3 rounded-xl text-primary-600 hover:bg-primary-50 transition-colors">
                    <i data-lucide="settings" class="w-5 h-5"></i>
                    Akun
                </a>
                <a href="#keamanan" class="flex items-center gap-3 px-4 py-3 rounded-xl text-primary-600 hover:bg-primary-50 transition-colors">
                    <i data-lucide="shield" class="w-5 h-5"></i>
                    Keamanan
                </a>
                <a href="#notifikasi" class="flex items-center gap-3 px-4 py-3 rounded-xl text-primary-600 hover:bg-primary-50 transition-colors">
                    <i data-lucide="bell" class="w-5 h-5"></i>
                    Notifikasi
                </a>
            </nav>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="lg:col-span-3 space-y-6">
        {{-- Store Profile --}}
        <div id="profil" class="bg-white rounded-2xl shadow-sm border border-primary-100 overflow-hidden">
            <div class="p-6 border-b border-primary-100">
                <h2 class="font-semibold text-primary-900 flex items-center gap-2">
                    <i data-lucide="store" class="w-5 h-5 text-primary-600"></i>
                    Profil Toko
                </h2>
                <p class="text-sm text-primary-500 mt-1">Informasi yang ditampilkan ke pembeli</p>
            </div>
            <div class="p-6">
                {{-- Store Logo --}}
                {{-- Store Logo --}}
                <div class="flex items-center gap-6 mb-6 pb-6 border-b border-primary-100">
                    <div class="w-24 h-24 rounded-2xl overflow-hidden shadow-md">
                        @if($seller && $seller->logo_toko)
                            <img src="{{ asset('storage/' . $seller->logo_toko) }}" alt="Logo Toko" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center text-white text-3xl font-bold">
                                {{ substr(Auth::user()->name ?? 'S', 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <h3 class="font-medium text-primary-900 mb-2">Logo Toko</h3>
                        <form action="{{ route('seller.upload-logo') }}" method="POST" enctype="multipart/form-data" id="logoForm" class="flex items-center gap-3">
                            @csrf
                            <input type="file" name="logo" id="logoInput" accept="image/jpeg,image/png,image/jpg" class="hidden">
                            <button type="button" onclick="document.getElementById('logoInput').click()" class="px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors">
                                Upload Logo
                            </button>
                            @if($seller && $seller->logo_toko)
                                <button type="submit" form="deleteLogoForm" onclick="return confirm('Yakin ingin menghapus logo?')" class="px-4 py-2 border border-red-200 text-red-600 text-sm font-medium rounded-lg hover:bg-red-50 transition-colors">
                                    Hapus
                                </button>
                            @endif
                        </form>
                        
                        @if($seller && $seller->logo_toko)
                            <form id="deleteLogoForm" action="{{ route('seller.delete-logo') }}" method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        @endif

                        <p class="text-xs text-primary-400 mt-2">JPG, PNG. Maks 2MB</p>
                        @error('logo')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <script>
                    document.getElementById('logoInput').addEventListener('change', function() {
                        if (this.files && this.files[0]) {
                            document.getElementById('logoForm').submit();
                        }
                    });
                </script>

                <form class="space-y-5">
                    <div class="grid md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-primary-700 mb-2">Nama Toko</label>
                            <input type="text" value="{{ Auth::user()->name ?? '' }}" 
                                   class="w-full px-4 py-3 border border-primary-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-primary-700 mb-2">Kategori Toko</label>
                            <select class="w-full px-4 py-3 border border-primary-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                                <option>Anyaman</option>
                                <option>Ukiran</option>
                                <option>Batik</option>
                                <option>Rajutan</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-primary-700 mb-2">Deskripsi Toko</label>
                        <textarea rows="4" placeholder="Ceritakan tentang toko Anda..."
                                  class="w-full px-4 py-3 border border-primary-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 resize-none"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-primary-700 mb-2">Alamat Toko</label>
                        <textarea rows="2" placeholder="Alamat lengkap toko Anda"
                                  class="w-full px-4 py-3 border border-primary-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 resize-none">{{ Auth::user()->alamat ?? '' }}</textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="px-6 py-3 bg-primary-600 text-white font-medium rounded-xl hover:bg-primary-700 transition-colors flex items-center gap-2">
                            <i data-lucide="save" class="w-4 h-4"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Account Info --}}
        <div id="akun" class="bg-white rounded-2xl shadow-sm border border-primary-100 overflow-hidden">
            <div class="p-6 border-b border-primary-100">
                <h2 class="font-semibold text-primary-900 flex items-center gap-2">
                    <i data-lucide="user" class="w-5 h-5 text-primary-600"></i>
                    Informasi Akun
                </h2>
                <p class="text-sm text-primary-500 mt-1">Data pribadi pemilik toko</p>
            </div>
            <div class="p-6">
                <form class="space-y-5">
                    <div class="grid md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-primary-700 mb-2">Nama Lengkap</label>
                            <input type="text" value="{{ Auth::user()->name ?? '' }}" 
                                   class="w-full px-4 py-3 border border-primary-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-primary-700 mb-2">Email</label>
                            <input type="email" value="{{ Auth::user()->email ?? '' }}" disabled
                                   class="w-full px-4 py-3 border border-primary-200 rounded-xl bg-primary-50 text-primary-500">
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-primary-700 mb-2">No. Telepon</label>
                            <input type="text" value="{{ Auth::user()->no_telepon ?? '' }}" placeholder="08xxxxxxxxxx"
                                   class="w-full px-4 py-3 border border-primary-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-primary-700 mb-2">Tanggal Lahir</label>
                            <input type="date" 
                                   class="w-full px-4 py-3 border border-primary-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="px-6 py-3 bg-primary-600 text-white font-medium rounded-xl hover:bg-primary-700 transition-colors flex items-center gap-2">
                            <i data-lucide="save" class="w-4 h-4"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Security --}}
        <div id="keamanan" class="bg-white rounded-2xl shadow-sm border border-primary-100 overflow-hidden">
            <div class="p-6 border-b border-primary-100">
                <h2 class="font-semibold text-primary-900 flex items-center gap-2">
                    <i data-lucide="shield" class="w-5 h-5 text-primary-600"></i>
                    Keamanan
                </h2>
                <p class="text-sm text-primary-500 mt-1">Kelola password dan keamanan akun</p>
            </div>
            <div class="p-6">
                <form class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-primary-700 mb-2">Password Lama</label>
                        <input type="password" placeholder="Masukkan password lama"
                               class="w-full px-4 py-3 border border-primary-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                    </div>
                    <div class="grid md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-primary-700 mb-2">Password Baru</label>
                            <input type="password" placeholder="Masukkan password baru"
                                   class="w-full px-4 py-3 border border-primary-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-primary-700 mb-2">Konfirmasi Password</label>
                            <input type="password" placeholder="Ulangi password baru"
                                   class="w-full px-4 py-3 border border-primary-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="px-6 py-3 bg-primary-600 text-white font-medium rounded-xl hover:bg-primary-700 transition-colors flex items-center gap-2">
                            <i data-lucide="key" class="w-4 h-4"></i>
                            Ubah Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Danger Zone --}}
        <div class="bg-white rounded-2xl shadow-sm border border-red-200 overflow-hidden">
            <div class="p-6 border-b border-red-100 bg-red-50">
                <h2 class="font-semibold text-red-700 flex items-center gap-2">
                    <i data-lucide="alert-triangle" class="w-5 h-5"></i>
                    Zona Berbahaya
                </h2>
            </div>
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-medium text-primary-900">Hapus Akun</h3>
                        <p class="text-sm text-primary-500">Setelah dihapus, akun tidak dapat dikembalikan</p>
                    </div>
                    <button class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors">
                        Hapus Akun
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
