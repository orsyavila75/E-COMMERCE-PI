@extends('template.main-template')

@section('title', 'Profil Saya - Kerajinan Nusantara')

@section('content')

{{-- Hero Banner --}}
<section class="bg-gradient-to-r from-primary-800 to-primary-900 py-12 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 right-0 w-96 h-96 bg-white rounded-full blur-3xl"></div>
    </div>
    <div class="container mx-auto px-4 relative z-10">
        <nav class="flex items-center gap-2 text-primary-300 text-sm mb-4">
            <a href="{{ url('/') }}" class="hover:text-white transition-colors">Beranda</a>
            <i data-lucide="chevron-right" class="w-4 h-4"></i>
            <span class="text-white">Profil</span>
        </nav>
        <h1 class="font-display text-3xl md:text-4xl font-bold text-white flex items-center gap-3">
            <i data-lucide="user" class="w-8 h-8"></i>
            Profil Saya
        </h1>
    </div>
</section>

{{-- Main Content --}}
<section class="py-8 bg-primary-50 min-h-screen">
    <div class="container mx-auto px-4">
        <div class="grid lg:grid-cols-4 gap-8">
            
            {{-- Sidebar --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-primary-100 p-6 sticky top-24">
                    {{-- Success Message --}}
                    @if(session('success'))
                        <div class="mb-4 p-3 bg-green-100 border border-green-200 text-green-700 rounded-xl text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Profile Picture --}}
                    <div class="text-center mb-6">
                        <div class="relative inline-block">
                            @if(Auth::user()->photo)
                                <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Profile" 
                                     class="w-24 h-24 rounded-2xl object-cover mx-auto mb-4 shadow-lg">
                            @else
                                <div class="w-24 h-24 bg-gradient-to-br from-primary-500 to-primary-700 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                                    <span class="text-4xl font-bold text-white">{{ substr(Auth::user()->name ?? 'U', 0, 1) }}</span>
                                </div>
                            @endif
                            {{-- Upload Button --}}
                            <form action="{{ route('profile.photo') }}" method="POST" enctype="multipart/form-data" id="photoForm">
                                @csrf
                                <label for="photoInput" class="absolute bottom-2 right-0 w-8 h-8 bg-primary-600 rounded-lg flex items-center justify-center cursor-pointer hover:bg-primary-700 transition-colors shadow-lg">
                                    <i data-lucide="camera" class="w-4 h-4 text-white"></i>
                                </label>
                                <input type="file" id="photoInput" name="photo" accept="image/*" class="hidden" onchange="document.getElementById('photoForm').submit()">
                            </form>
                        </div>
                        <h3 class="font-semibold text-primary-900">{{ Auth::user()->name ?? 'User' }}</h3>
                        <p class="text-sm text-primary-500">{{ Auth::user()->email ?? 'user@example.com' }}</p>
                        <span class="inline-flex mt-2 px-3 py-1 text-xs font-medium bg-primary-100 text-primary-700 rounded-full capitalize">
                            {{ Auth::user()->role ?? 'customer' }}
                        </span>
                    </div>

                    {{-- Menu --}}
                    <nav class="space-y-2">
                        <a href="#akun" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-primary-100 text-primary-700 font-medium">
                            <i data-lucide="user" class="w-5 h-5"></i>
                            Informasi Akun
                        </a>
                        <a href="#alamat" class="flex items-center gap-3 px-4 py-3 rounded-xl text-primary-600 hover:bg-primary-50 transition-colors">
                            <i data-lucide="map-pin" class="w-5 h-5"></i>
                            Alamat
                        </a>
                        <a href="#keamanan" class="flex items-center gap-3 px-4 py-3 rounded-xl text-primary-600 hover:bg-primary-50 transition-colors">
                            <i data-lucide="shield" class="w-5 h-5"></i>
                            Keamanan
                        </a>
                        <a href="#notifikasi" class="flex items-center gap-3 px-4 py-3 rounded-xl text-primary-600 hover:bg-primary-50 transition-colors">
                            <i data-lucide="bell" class="w-5 h-5"></i>
                            Notifikasi
                        </a>
                        <div class="border-t border-primary-100 my-4"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-600 hover:bg-red-50 transition-colors">
                                <i data-lucide="log-out" class="w-5 h-5"></i>
                                Logout
                            </button>
                        </form>
                    </nav>
                </div>
            </div>

            {{-- Main Content --}}
            <div class="lg:col-span-3 space-y-6">
                
                {{-- Account Information --}}
                <div id="akun" class="bg-white rounded-2xl shadow-sm border border-primary-100 overflow-hidden">
                    <div class="p-6 border-b border-primary-100">
                        <h2 class="font-semibold text-lg text-primary-900 flex items-center gap-2">
                            <i data-lucide="user" class="w-5 h-5 text-primary-600"></i>
                            Informasi Akun
                        </h2>
                        <p class="text-sm text-primary-500 mt-1">Kelola informasi profil Anda</p>
                    </div>
                    <form action="{{ route('profile.update') }}" method="POST" class="p-6">
                        @csrf
                        <div class="grid md:grid-cols-2 gap-6">
                            {{-- Nama --}}
                            <div>
                                <label class="block text-sm font-medium text-primary-700 mb-2">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ Auth::user()->name ?? '' }}" 
                                       class="w-full px-4 py-3 border border-primary-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                            </div>

                            {{-- Email --}}
                            <div>
                                <label class="block text-sm font-medium text-primary-700 mb-2">Email</label>
                                <input type="email" value="{{ Auth::user()->email ?? '' }}" 
                                       class="w-full px-4 py-3 border border-primary-200 rounded-xl bg-primary-50 text-primary-500" disabled>
                                <p class="text-xs text-primary-400 mt-1">Email tidak dapat diubah</p>
                            </div>

                            {{-- No Telepon --}}
                            <div>
                                <label class="block text-sm font-medium text-primary-700 mb-2">No. Telepon</label>
                                <input type="text" name="no_telepon" value="{{ Auth::user()->no_telepon ?? '' }}" placeholder="08xxxxxxxxxx"
                                       class="w-full px-4 py-3 border border-primary-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                            </div>

                            {{-- Tanggal Bergabung --}}
                            <div>
                                <label class="block text-sm font-medium text-primary-700 mb-2">Bergabung Sejak</label>
                                <input type="text" value="{{ Auth::user()->created_at ? Auth::user()->created_at->format('d F Y') : 'November 2024' }}" 
                                       class="w-full px-4 py-3 border border-primary-200 rounded-xl bg-primary-50 text-primary-500" disabled>
                            </div>
                        </div>

                        {{-- Alamat --}}
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-primary-700 mb-2">Alamat</label>
                            <textarea name="alamat" rows="3" placeholder="Alamat lengkap Anda"
                                      class="w-full px-4 py-3 border border-primary-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 resize-none">{{ Auth::user()->alamat ?? '' }}</textarea>
                        </div>

                        <div class="flex justify-end mt-6">
                            <button type="submit" class="px-6 py-3 bg-primary-600 text-white font-medium rounded-xl hover:bg-primary-700 transition-colors flex items-center gap-2">
                                <i data-lucide="save" class="w-4 h-4"></i>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>

                {{-- BLOK: Seller kirim ulang permintaan persetujuan --}}
                @auth
                    @if (Auth::user()->role === 'seller')
                        @php
                            $sellerData = \App\Models\Seller::where('id_seller', Auth::user()->id_user)->first();
                        @endphp

                        @if ($sellerData && $sellerData->status === 'rejected')
                            <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4">
                                <p class="text-sm text-amber-800 mb-3">
                                    Pendaftaran seller Anda sebelumnya <span class="font-semibold">ditolak</span>.
                                    Setelah memperbarui data akun, Anda dapat mengirim ulang permintaan persetujuan ke admin.
                                </p>

                                <form method="POST"
                                      action="{{ route('seller.request_approval_again') }}"
                                      onsubmit="return confirm('Kirim ulang permintaan persetujuan ke admin?');">
                                    @csrf
                                    <button type="submit"
                                            class="px-4 py-2 rounded-xl bg-primary-600 text-white text-sm font-semibold hover:bg-primary-700 transition-colors">
                                        Kirim Ulang Permintaan Persetujuan
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endif
                @endauth

                {{-- Address --}}
                <div id="alamat" class="bg-white rounded-2xl shadow-sm border border-primary-100 overflow-hidden">
                    <div class="p-6 border-b border-primary-100 flex items-center justify-between">
                        <div>
                            <h2 class="font-semibold text-lg text-primary-900 flex items-center gap-2">
                                <i data-lucide="map-pin" class="w-5 h-5 text-primary-600"></i>
                                Alamat Pengiriman
                            </h2>
                            <p class="text-sm text-primary-500 mt-1">Kelola alamat pengiriman Anda</p>
                        </div>
                        <button class="px-4 py-2 bg-primary-100 text-primary-700 font-medium rounded-xl hover:bg-primary-200 transition-colors flex items-center gap-2 text-sm">
                            <i data-lucide="plus" class="w-4 h-4"></i>
                            Tambah Alamat
                        </button>
                    </div>
                    <div class="p-6">
                        {{-- Address Card --}}
                        <div class="border border-primary-200 rounded-xl p-4 relative">
                            <span class="absolute top-4 right-4 px-2 py-1 text-xs font-medium bg-primary-100 text-primary-700 rounded-full">Utama</span>
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i data-lucide="home" class="w-5 h-5 text-primary-600"></i>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-medium text-primary-900">{{ Auth::user()->name ?? 'User' }}</h4>
                                    <p class="text-sm text-primary-500 mt-1">{{ Auth::user()->no_telepon ?? '08xxxxxxxxxx' }}</p>
                                    <p class="text-sm text-primary-600 mt-2">{{ Auth::user()->alamat ?? 'Alamat belum diatur' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 mt-4 pt-4 border-t border-primary-100">
                                <a href="#akun" onclick="document.querySelector('textarea[name=alamat]').focus()" class="text-sm text-primary-600 hover:text-primary-800 font-medium flex items-center gap-1">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                    Ubah
                                </a>
                                <form action="{{ route('profile.address.delete') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus alamat ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-medium flex items-center gap-1">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Security --}}
                <div id="keamanan" class="bg-white rounded-2xl shadow-sm border border-primary-100 overflow-hidden">
                    <div class="p-6 border-b border-primary-100">
                        <h2 class="font-semibold text-lg text-primary-900 flex items-center gap-2">
                            <i data-lucide="shield" class="w-5 h-5 text-primary-600"></i>
                            Keamanan Akun
                        </h2>
                        <p class="text-sm text-primary-500 mt-1">Kelola password dan keamanan akun</p>
                    </div>
                    <div class="p-6">
                        <form class="space-y-6" action="{{ route('profile.password') }}" method="POST">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-primary-700 mb-2">Password Lama</label>
                                <div class="relative">
                                    <i data-lucide="lock" class="w-5 h-5 text-primary-400 absolute left-4 top-1/2 -translate-y-1/2"></i>
                                    <input type="password" name="current_password" placeholder="Masukkan password lama"
                                           class="w-full pl-12 pr-4 py-3 border border-primary-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                                </div>
                            </div>
                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-primary-700 mb-2">Password Baru</label>
                                    <div class="relative">
                                        <i data-lucide="lock" class="w-5 h-5 text-primary-400 absolute left-4 top-1/2 -translate-y-1/2"></i>
                                        <input type="password" name="password" placeholder="Masukkan password baru"
                                               class="w-full pl-12 pr-4 py-3 border border-primary-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-primary-700 mb-2">Konfirmasi Password</label>
                                    <div class="relative">
                                        <i data-lucide="lock" class="w-5 h-5 text-primary-400 absolute left-4 top-1/2 -translate-y-1/2"></i>
                                        <input type="password" name="password_confirmation" placeholder="Ulangi password baru"
                                               class="w-full pl-12 pr-4 py-3 border border-primary-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                                    </div>
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

                {{-- Notifications --}}
                <div id="notifikasi" class="bg-white rounded-2xl shadow-sm border border-primary-100 overflow-hidden">
                    <div class="p-6 border-b border-primary-100">
                        <h2 class="font-semibold text-lg text-primary-900 flex items-center gap-2">
                            <i data-lucide="bell" class="w-5 h-5 text-primary-600"></i>
                            Pengaturan Notifikasi
                        </h2>
                    </div>
                    <div class="p-6">
                        <form>
                            <label class="flex items-center justify-between gap-4 py-3">
                                <div>
                                    <p class="font-medium text-primary-900">Promo & Diskon</p>
                                    <p class="text-sm text-primary-500">Terima info promo dan diskon terbaru</p>
                                </div>
                                <input type="checkbox" checked class="w-5 h-5 rounded border-primary-300 text-primary-600 focus:ring-primary-500">
                            </label>

                            <div class="flex justify-end mt-4">
                                <button type="submit" class="px-6 py-3 bg-primary-600 text-white font-medium rounded-xl hover:bg-primary-700 transition-colors flex items-center gap-2">
                                    <i data-lucide="save" class="w-4 h-4"></i>
                                    Simpan Notifikasi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection
