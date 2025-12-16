@extends('template.main-template')

@section('title', 'Login Admin')

@section('content')
<section class="py-16">
    <div class="container mx-auto px-4 max-w-md">
        <h1 class="text-2xl font-bold mb-6 text-center">Login Admin</h1>

        <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium mb-1">Email</label>
                <input type="email"
                       name="email"
                       value="{{ old('email') }}"
                       required
                       class="w-full border rounded-lg px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Password</label>
                <input type="password"
                       name="password"
                       required
                       class="w-full border rounded-lg px-3 py-2">
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember" class="text-sm">Ingat saya</label>
            </div>

            @error('email')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror

            <button type="submit"
                    class="w-full bg-primary-600 text-white py-2 rounded-lg font-semibold">
                Masuk sebagai Admin
            </button>
        </form>
    </div>
</section>
@endsection
