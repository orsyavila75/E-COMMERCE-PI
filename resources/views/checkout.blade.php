@extends('template.main-template')

@section('content')
<div class="max-w-4xl mx-auto p-8 bg-white rounded-xl shadow-lg mt-8">
    <h1 class="text-3xl font-bold mb-6">Checkout</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    @if(empty($cart) || count($cart) === 0)
        <p>Keranjang kosong. <a href="{{ route('products.page') }}" class="text-blue-600">Kembali ke produk</a></p>
    @else
        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h2 class="text-xl font-semibold mb-3">Detail Pemesanan</h2>

                    <div class="space-y-4">
                        @php $calcTotal = 0; @endphp
                        @foreach($cart as $key => $item)
                            @php $subtotal = ($item['price'] * $item['qty']); $calcTotal += $subtotal; @endphp
                            <div class="flex items-center gap-4 p-3 border rounded">
                                @if(!empty($item['image']))
                                    <img src="{{ asset('images/' . rawurlencode(basename($item['image']))) }}" alt="" class="w-20 h-20 object-cover rounded">
                                @endif
                                <div>
                                    <div class="font-medium">{{ $item['name'] }}</div>
                                    <div class="text-sm text-gray-600">{{ $item['qty'] }} x Rp {{ number_format($item['price'],0,',','.') }}</div>
                                    <div class="text-sm font-semibold mt-1">Subtotal: Rp {{ number_format($subtotal,0,',','.') }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4 text-right">
                        <div class="text-lg">Total Pesanan: <span class="font-extrabold">Rp {{ number_format($calcTotal,0,',','.') }}</span></div>
                    </div>
                </div>

                <div>
                    <h2 class="text-xl font-semibold mb-3">Alamat Pengiriman</h2>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Alamat</label>
                        <textarea name="shipping_address" rows="5" class="w-full border rounded p-2">{{ old('shipping_address', auth()->user()->alamat ?? '') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Metode Pembayaran (mock)</label>
                        <select name="payment_method" class="w-full border rounded p-2">
                            <option value="manual">Transfer Bank (manual)</option>
                            <option value="cod">Bayar di Tempat (COD)</option>
                        </select>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="w-full py-3 bg-[#7A3E10] text-white font-bold rounded">Konfirmasi & Bayar</button>
                    </div>
                </div>
            </div>
        </form>
    @endif
</div>
@endsection
