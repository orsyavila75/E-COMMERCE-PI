@extends('template.main-template') {{-- Menggunakan layout Dashboard Pengguna --}}

@section('content')

    <h1 class="text-3xl font-semibold text-gray-900 mb-8">Delete Account</h1>

    <div class="max-w-xl mt-10 p-6">

        <div class="bg-red-50 p-8 rounded-lg mb-10 border border-red-200">
            <h3 class="text-xl font-bold text-red-700 mb-3">PERHATIAN</h3>
            <p class="text-red-800 italic text-lg leading-relaxed">
                Dengan melanjutkan proses penghapusan, Anda mengerti bahwa **semua data akun** Anda (riwayat transaksi, daftar produk, ulasan, dll.) **akan hilang secara permanen** dan tidak dapat dikembalikan.
            </p>
        </div>

        <form action="#" method="POST">
            @csrf

            {{-- Input konfirmasi password untuk keamanan --}}
            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    Masukkan Kata Sandi Anda untuk Konfirmasi:
                </label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                       class="w-full p-3 border border-gray-400 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-600"
                       required>
            </div>

            <button type="submit"
                    class="px-10 py-3 text-white font-medium rounded-lg shadow-lg hover:opacity-90 transition duration-150 block w-full text-center text-lg"
                    style="background-color: #934c26;">
                Ajukan Penghapusan Akun
            </button>
        </form>

        @if(session('delete_request_sent'))
            <div class="mt-8 text-center p-4 bg-green-50 rounded-lg">
                <p class="text-green-700 italic text-sm flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-11.44 9.17A7 7 0 0112 17a7 7 0 01-9.56-.83A2 2 0 012.55 15V7a2 2 0 012-2h15a2 2 0 012 2v8a2 2 0 01-1.45 1.84z" />
                    </svg>
                    Email konfirmasi dan instruksi penghapusan telah dikirim ke email Anda.
                </p>
            </div>
        @endif

    </div>

@endsection
