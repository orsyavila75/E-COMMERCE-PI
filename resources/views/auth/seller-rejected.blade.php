@extends('template.main-template')

@section('title', 'Pendaftaran Seller Ditolak')

@section('content')
<section class="py-16 bg-primary-50 min-h-screen">
    <div class="container mx-auto px-4">
        <div class="max-w-xl mx-auto bg-white rounded-2xl shadow-sm border border-primary-100 p-8 text-center">
            {{-- Icon --}}
            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-red-50 flex items-center justify-center">
                <span class="text-2xl">✖</span>
            </div>

            <h1 class="text-2xl font-bold text-primary-900 mb-3">
                Pendaftaran Seller Ditolak
            </h1>
            <p class="text-sm text-primary-600 leading-relaxed mb-8">
                Maaf, pendaftaran Anda sebagai seller belum dapat kami terima saat ini.
                Silakan cek kembali data toko Anda atau hubungi admin untuk informasi lebih lanjut.
            </p>

            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('profile') }}"
                   class="inline-flex justify-center px-6 py-3 rounded-xl bg-primary-600 text-white text-sm font-semibold hover:bg-primary-700 transition-colors">
                    Perbarui Data Akun
                </a>
            </div>

            <p class="mt-8 text-xs text-primary-400">
                Jika Anda merasa ini adalah kesalahan, silakan hubungi tim admin melalui menu chat.
            </p>
        </div>
    </div>
</section>
@endsection
