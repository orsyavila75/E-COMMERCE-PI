@extends('template.main-template')

@section('title', 'Daftar Akun')

@section('content')
<section class="py-16 bg-primary-50 min-h-screen">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-sm border border-primary-100 p-8">
            <h1 class="text-2xl font-bold text-primary-900 mb-2">
                Daftar Akun
            </h1>
            <p class="text-sm text-primary-500 mb-6">
                Buat akun sebagai <span class="font-semibold">Customer</span> atau <span class="font-semibold">Seller</span>.
            </p>

            @if ($errors->any())
                <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                {{-- Data akun umum --}}
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-primary-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="w-full px-4 py-3 border border-primary-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-primary-700 mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="w-full px-4 py-3 border border-primary-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-primary-700 mb-2">Password</label>
                        <input type="password" name="password"
                               class="w-full px-4 py-3 border border-primary-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-primary-700 mb-2">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation"
                               class="w-full px-4 py-3 border border-primary-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-primary-700 mb-2">No. Telepon</label>
                        <input type="text" name="no_telepon" value="{{ old('no_telepon') }}"
                               class="w-full px-4 py-3 border border-primary-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-primary-700 mb-2">Peran</label>
                        <select name="role" id="roleSelect"
                                class="w-full px-4 py-3 border border-primary-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                            <option value="customer" {{ old('role') === 'customer' ? 'selected' : '' }}>Customer</option>
                            <option value="seller" {{ old('role') === 'seller' ? 'selected' : '' }}>Seller</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-primary-700 mb-2">Alamat</label>
                    <textarea name="alamat" rows="3"
                              class="w-full px-4 py-3 border border-primary-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 resize-none">{{ old('alamat') }}</textarea>
                </div>

                {{-- Bagian khusus seller --}}
                <div id="sellerFields" class="space-y-6 border-t border-primary-100 pt-6 {{ old('role','customer') === 'seller' ? '' : 'hidden' }}">
                    <h2 class="text-lg font-semibold text-primary-900">
                        Data Toko (Seller)
                    </h2>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-primary-700 mb-2">Nama Toko</label>
                            <input type="text" name="nama_toko" value="{{ old('nama_toko') }}"
                                   class="w-full px-4 py-3 border border-primary-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-primary-700 mb-2">Kategori Produk</label>
                            <input type="text" name="kategori_produk" value="{{ old('kategori_produk') }}"
                                   class="w-full px-4 py-3 border border-primary-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-primary-700 mb-2">Deskripsi Toko</label>
                        <textarea name="deskripsi_toko" rows="3"
                                  class="w-full px-4 py-3 border border-primary-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 resize-none">{{ old('deskripsi_toko') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-primary-700 mb-2">Alamat Pengiriman</label>
                        <textarea name="alamat_pengiriman" rows="3"
                                  class="w-full px-4 py-3 border border-primary-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 resize-none">{{ old('alamat_pengiriman') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-primary-700 mb-2">Logo Toko (maks 2MB)</label>
                        <input type="file" name="logo_toko"
                               class="w-full px-4 py-2 border border-primary-200 rounded-xl bg-primary-50">
                    </div>
                </div>

                <div class="flex justify-between items-center pt-4">
                    <p class="text-sm text-primary-500">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="text-primary-700 font-semibold hover:underline">
                            Login di sini
                        </a>
                    </p>

                    <button type="submit"
                            class="px-6 py-3 bg-primary-600 text-white font-semibold rounded-xl hover:bg-primary-700 transition-colors">
                        Daftar
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

{{-- Simple toggle seller fields --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const roleSelect = document.getElementById('roleSelect');
        const sellerFields = document.getElementById('sellerFields');

        function toggleSellerFields() {
            if (roleSelect.value === 'seller') {
                sellerFields.classList.remove('hidden');
            } else {
                sellerFields.classList.add('hidden');
            }
        }

        roleSelect.addEventListener('change', toggleSellerFields);
        toggleSellerFields();
    });
</script>
@endsection
