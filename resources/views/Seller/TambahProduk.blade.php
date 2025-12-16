@extends('seller-template')

@section('content')
@php
    if (!isset($errors) || !($errors instanceof \Illuminate\Support\ViewErrorBag)) {
        $errors = new \Illuminate\Support\ViewErrorBag();
    }
@endphp
<div class="max-w-3xl mx-auto p-4 py-8">
    <h1 class="text-xl font-bold text-brown-800 mb-4">Tambah Produk</h1>

    <form action="{{ route('seller.products.store') }}" method="POST"
          class="bg-white p-5 rounded-2xl shadow border">
        @csrf

        <div class="mb-3">
            <label class="text-sm">Nama Produk</label>
            <input name="name" class="w-full border rounded-lg p-2 mt-1" required>
            @error('name') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-3">
            <label class="text-sm">Harga</label>
            <input name="price" type="number" class="w-full border rounded-lg p-2 mt-1" required>
            @error('price') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-3">
            <label class="text-sm">Stok</label>
            <input name="stock" type="number" class="w-full border rounded-lg p-2 mt-1" required>
            @error('stock') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-3">
            <label class="text-sm">Image URL (opsional)</label>
            <input name="image_url" class="w-full border rounded-lg p-2 mt-1">
            @error('image_url') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-3">
            <label class="text-sm">Deskripsi</label>
            <textarea name="description" rows="4" class="w-full border rounded-lg p-2 mt-1"></textarea>
        </div>

        <button class="px-4 py-2 bg-brown-800 text-white rounded-full text-sm font-semibold hover:bg-brown-900">
            Simpan Produk
        </button>
    </form>
</div>
@endsection
