@extends('seller-template')

@section('content')
@php
    $product = $product ?? (object)[
        'name' => 'Produk Contoh',
        'price' => 150000,
        'description' => 'Deskripsi produk',
        'image_url' => null,
        'reviews' => collect([])
    ];
@endphp
<div class="max-w-4xl mx-auto p-4 py-8">
    <div class="bg-white rounded-2xl shadow border overflow-hidden">
        <div class="h-64 bg-gray-200">
            @if($product->image_url)
                <img src="{{ $product->image_url }}" class="w-full h-full object-cover" />
            @endif
        </div>

        <div class="p-6">
            <h1 class="text-xl font-bold text-brown-800">{{ $product->name }}</h1>
            <p class="text-sm text-gray-600 mt-1">
                Rp {{ number_format($product->price,0,',','.') }}
            </p>

            <p class="text-sm mt-4">
                {{ $product->description ?? 'Tidak ada deskripsi.' }}
            </p>

            <hr class="my-4">

            <h2 class="font-semibold text-brown-800 mb-2">Ulasan Customer</h2>
            @forelse($product->reviews as $review)
                <div class="border-b py-2 text-sm">
                    <div class="flex items-center justify-between">
                        <span class="font-medium">{{ $review->user->name ?? 'Customer' }}</span>
                        <span>⭐ {{ $review->rating }}</span>
                    </div>
                    <p class="text-gray-600 text-xs mt-1">{{ $review->comment }}</p>
                </div>
            @empty
                <p class="text-sm text-gray-500">Belum ada ulasan.</p>
            @endforelse

        </div>
    </div>
</div>
@endsection
