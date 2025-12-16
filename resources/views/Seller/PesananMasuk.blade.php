@extends('seller-template')

@section('content')
@php
    $orders = $orders ?? collect([]);
@endphp
<div class="max-w-6xl mx-auto p-4 py-8">
    <h1 class="text-xl font-bold text-brown-800 mb-4">Pesanan Masuk</h1>

    <div class="bg-white rounded-2xl shadow border overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-brown-50 text-brown-800">
                <tr>
                    <th class="p-3 text-left">Order ID</th>
                    <th class="p-3 text-left">Pembeli</th>
                    <th class="p-3 text-left">Status</th>
                    <th class="p-3 text-left">Total</th>
                    <th class="p-3 text-left">Tanggal</th>
                </tr>
            </thead>
            <tbody>
            @forelse($orders as $order)
                <tr class="border-t">
                    <td class="p-3">#{{ $order->id }}</td>
                    <td class="p-3">{{ $order->buyer->name ?? '-' }}</td>
                    <td class="p-3 capitalize">{{ $order->status }}</td>
                    <td class="p-3">Rp {{ number_format($order->total,0,',','.') }}</td>
                    <td class="p-3">{{ $order->created_at->format('d M Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-4 text-center text-gray-500">Belum ada pesanan masuk.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    @if(method_exists($orders, 'links'))
    <div class="mt-4">
        {{ $orders->links() }}
    </div>
    @endif
</div>
@endsection
