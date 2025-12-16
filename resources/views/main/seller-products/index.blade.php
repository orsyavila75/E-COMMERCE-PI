@extends('template.main-template')

@section('content')
@php
    $products = $products ?? collect([]);
@endphp
<div class="max-w-6xl mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Kelola Produk Saya</h1>
        <a href="{{ route('seller.add-product') }}" class="px-4 py-2 bg-green-600 text-white rounded">Tambah Produk</a>
    </div>

    @if(session('success'))
        <div class="mb-4 text-green-700">{{ session('success') }}</div>
    @endif

    <table class="w-full bg-white rounded shadow">
        <thead>
            <tr class="text-left border-b">
                <th class="p-3">Nama</th>
                <th class="p-3">Harga</th>
                <th class="p-3">Stok</th>
                <th class="p-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $p)
                <tr class="border-b">
                    <td class="p-3">{{ $p->nama_produk }}</td>
                    <td class="p-3">Rp {{ number_format($p->harga, 0, ',', '.') }}</td>
                    <td class="p-3">{{ $p->stock }}</td>
                    <td class="p-3">
                        <a href="{{ route('seller.products.edit', $p->id_produk) }}" class="text-blue-600 mr-3">Edit</a>
                        <form action="{{ route('seller.products.destroy', $p->id_produk) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Hapus produk ini?')" class="text-red-600">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="p-4 text-center text-gray-600">Belum ada produk.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
