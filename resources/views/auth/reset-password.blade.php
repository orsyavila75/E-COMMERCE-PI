@extends('template.auth-template')

@section('title', 'Reset Password - Kerajinan Nusantara')

@section('content')
<div class="min-h-screen w-full flex items-center justify-center p-4 bg-gradient-to-br from-primary-50 to-primary-100 relative overflow-hidden">
    {{-- Background Blobs --}}
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
        <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] bg-primary-200/30 rounded-full blur-3xl animate-blob"></div>
        <div class="absolute top-[20%] -right-[10%] w-[40%] h-[40%] bg-secondary-200/30 rounded-full blur-3xl animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-[20%] left-[20%] w-[40%] h-[40%] bg-primary-300/20 rounded-full blur-3xl animate-blob animation-delay-4000"></div>
    </div>

    <div class="w-full max-w-md bg-white/80 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/50 p-8 relative z-10">
        {{-- Header --}}
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-gradient-to-br from-primary-600 to-primary-800 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-primary-500/20">
                <i data-lucide="lock-keyhole" class="w-8 h-8 text-white"></i>
            </div>
            <h1 class="font-display text-2xl font-bold text-primary-900 mb-2">Reset Password</h1>
            <p class="text-primary-500 text-sm">Buat password baru untuk akun Anda.</p>
        </div>

        {{-- Form --}}
        <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div>
                <label class="block text-sm font-medium text-primary-700 mb-2">Email</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i data-lucide="mail" class="w-5 h-5 text-primary-400 group-focus-within:text-primary-600 transition-colors"></i>
                    </div>
                    <input type="email" name="email" value="{{ $email ?? old('email') }}" required autofocus
                           class="w-full pl-11 pr-4 py-3.5 bg-white border border-primary-200 rounded-xl text-primary-900 placeholder-primary-300 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all duration-300">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-primary-700 mb-2">Password Baru</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i data-lucide="lock" class="w-5 h-5 text-primary-400 group-focus-within:text-primary-600 transition-colors"></i>
                    </div>
                    <input type="password" name="password" required
                           class="w-full pl-11 pr-4 py-3.5 bg-white border border-primary-200 rounded-xl text-primary-900 placeholder-primary-300 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all duration-300"
                           placeholder="Minimal 8 karakter">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-primary-700 mb-2">Konfirmasi Password</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i data-lucide="lock" class="w-5 h-5 text-primary-400 group-focus-within:text-primary-600 transition-colors"></i>
                    </div>
                    <input type="password" name="password_confirmation" required
                           class="w-full pl-11 pr-4 py-3.5 bg-white border border-primary-200 rounded-xl text-primary-900 placeholder-primary-300 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all duration-300"
                           placeholder="Ulangi password baru">
                </div>
            </div>

            <button type="submit" 
                    class="w-full py-3.5 bg-gradient-to-r from-primary-600 to-primary-700 text-white font-semibold rounded-xl hover:from-primary-700 hover:to-primary-800 focus:ring-4 focus:ring-primary-500/30 transition-all duration-300 shadow-lg shadow-primary-500/30 flex items-center justify-center gap-2 group">
                <span>Reset Password</span>
                <i data-lucide="arrow-right" class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
            </button>
        </form>
    </div>
</div>
@endsection
