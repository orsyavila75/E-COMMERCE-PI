@extends('template.auth-template')

@section('title', 'Menunggu Persetujuan - Kerajinan Nusantara')

@section('content')
<div class="w-full min-h-screen flex items-center justify-center bg-gray-50 px-4">
    <div class="max-w-md w-full bg-white rounded-xl shadow-sm border border-gray-100 p-8 text-center">
        {{-- Icon --}}
        <div class="w-16 h-16 bg-amber-50 rounded-full flex items-center justify-center mx-auto mb-6">
            <i data-lucide="clock" class="w-8 h-8 text-amber-600"></i>
        </div>
        
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Menunggu Persetujuan</h1>
        <p class="text-gray-600 mb-8">
            Akun Anda sedang dalam proses verifikasi. Mohon tunggu 1x24 jam.
        </p>

        {{-- Simple Timeline --}}
        <div class="text-left space-y-4 mb-8 max-w-xs mx-auto">
            <div class="flex gap-3">
                <div class="flex flex-col items-center">
                    <div class="w-2 h-2 rounded-full bg-green-500 mt-2"></div>
                    <div class="w-0.5 h-full bg-gray-200 my-1"></div>
                </div>
                <div class="pb-4">
                    <p class="text-sm font-medium text-gray-900">Pendaftaran Berhasil</p>
                    <p class="text-xs text-gray-500">Data Anda telah kami terima.</p>
                </div>
            </div>
            <div class="flex gap-3">
                <div class="flex flex-col items-center">
                    <div class="w-2 h-2 rounded-full bg-amber-500 mt-2 animate-pulse"></div>
                    <div class="w-0.5 h-full bg-gray-200 my-1"></div>
                </div>
                <div class="pb-4">
                    <p class="text-sm font-medium text-gray-900">Verifikasi Admin</p>
                    <p class="text-xs text-gray-500">Sedang ditinjau oleh tim kami.</p>
                </div>
            </div>
            <div class="flex gap-3">
                <div class="flex flex-col items-center">
                    <div class="w-2 h-2 rounded-full bg-gray-300 mt-2"></div>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-400">Akun Aktif</p>
                    <p class="text-xs text-gray-400">Siap berjualan.</p>
                </div>
            </div>
        </div>

        <div class="space-y-3">
            <a href="{{ url('/') }}" class="w-full py-2.5 px-4 bg-primary-600 text-white font-medium rounded-lg hover:bg-primary-700 transition-colors flex items-center justify-center gap-2">
                <i data-lucide="home" class="w-4 h-4"></i>
                Kembali ke Beranda
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full py-2.5 px-4 bg-white border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors flex items-center justify-center gap-2">
                    <i data-lucide="log-out" class="w-4 h-4"></i>
                    Keluar Akun
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
