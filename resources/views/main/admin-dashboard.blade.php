@extends('template.main-template')

@section('title', 'Dashboard Admin')

@section('content')
<section class="py-10 bg-primary-50 min-h-screen">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-6 text-primary-900">Dashboard Admin</h1>

        {{-- Notifikasi sukses / error --}}
        @if (session('success'))
            <div class="mb-4 px-4 py-3 rounded-xl bg-green-50 border border-green-200 text-sm text-green-800">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 px-4 py-3 rounded-xl bg-red-50 border border-red-200 text-sm text-red-800">
                {{ session('error') }}
            </div>
        @endif

        @if (session('info'))
            <div class="mb-4 px-4 py-3 rounded-xl bg-blue-50 border border-blue-200 text-sm text-blue-800">
                {{ session('info') }}
            </div>
        @endif

        {{-- Kartu statistik --}}
        <div class="grid md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white rounded-2xl shadow-sm border border-primary-100 p-6">
                <p class="text-sm text-primary-500 mb-1">Total Customer</p>
                <p class="text-3xl font-bold text-primary-900">{{ $totalCustomers }}</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-primary-100 p-6">
                <p class="text-sm text-primary-500 mb-1">Total Seller</p>
                <p class="text-3xl font-bold text-primary-900">{{ $totalSellers }}</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-primary-100 p-6">
                <p class="text-sm text-primary-500 mb-1">Seller Pending</p>
                <p class="text-3xl font-bold text-amber-600">{{ $pendingSellers }}</p>
            </div>
        </div>

        {{-- =================================================== --}}
        {{-- 1. Seller Pending (Perlu Diverifikasi)              --}}
        {{-- =================================================== --}}
        <div class="bg-white rounded-2xl shadow-sm border border-primary-100 p-6 mb-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-primary-900">
                    Pendaftaran Seller yang Perlu Diverifikasi
                </h2>
                <span class="text-sm text-primary-500">
                    Total: {{ $pendingSellerList->count() }} seller pending
                </span>
            </div>

            @if ($pendingSellerList->isEmpty())
                <p class="text-sm text-primary-500 mt-4">
                    Belum ada pendaftaran seller yang menunggu verifikasi.
                </p>
            @else
                <div class="mt-6 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-primary-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-primary-700 font-medium">Nama Toko</th>
                                <th class="px-4 py-2 text-left text-primary-700 font-medium">Kategori</th>
                                <th class="px-4 py-2 text-left text-primary-700 font-medium">Pemilik</th>
                                <th class="px-4 py-2 text-left text-primary-700 font-medium">Status</th>
                                <th class="px-4 py-2 text-left text-primary-700 font-medium">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-primary-100">
                            @foreach ($pendingSellerList as $seller)
                                <tr>
                                    <td class="px-4 py-3 text-primary-900">
                                        {{ $seller->nama_toko ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-primary-700">
                                        {{ $seller->kategori_produk ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-primary-700">
                                        {{ optional($seller->user)->name ?? ($seller->nama_pemilik ?? $seller->nama ?? '-') }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex px-2 py-1 text-xs rounded-full bg-amber-100 text-amber-700">
                                            {{ ucfirst($seller->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2">
                                            {{-- Tombol Setujui --}}
                                            <form method="POST"
                                                  action="{{ route('admin.seller.approve', $seller->getKey()) }}"
                                                  onsubmit="return confirm('Setujui seller ini?');">
                                                @csrf
                                                <button type="submit"
                                                        class="px-3 py-1 rounded-lg text-xs font-semibold bg-green-600 text-white hover:bg-green-700">
                                                    Setujui
                                                </button>
                                            </form>

                                            {{-- Tombol Tolak --}}
                                            <form method="POST"
                                                  action="{{ route('admin.seller.reject', $seller->getKey()) }}"
                                                  onsubmit="return confirm('Tolak pendaftaran seller ini?');">
                                                @csrf
                                                <button type="submit"
                                                        class="px-3 py-1 rounded-lg text-xs font-semibold bg-red-600 text-white hover:bg-red-700">
                                                    Tolak
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        {{-- =================================================== --}}
        {{-- 2. Seller yang Disetujui                           --}}
        {{-- =================================================== --}}
        <div class="bg-white rounded-2xl shadow-sm border border-primary-100 p-6 mb-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-primary-900">
                    Seller yang Disetujui
                </h2>
                <span class="text-sm text-primary-500">
                    Total: {{ $approvedSellerList->count() }} seller approved
                </span>
            </div>

            @if ($approvedSellerList->isEmpty())
                <p class="text-sm text-primary-500 mt-4">
                    Belum ada seller yang disetujui.
                </p>
            @else
                <div class="mt-6 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-primary-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-primary-700 font-medium">Nama Toko</th>
                                <th class="px-4 py-2 text-left text-primary-700 font-medium">Kategori</th>
                                <th class="px-4 py-2 text-left text-primary-700 font-medium">Pemilik</th>
                                <th class="px-4 py-2 text-left text-primary-700 font-medium">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-primary-100">
                            @foreach ($approvedSellerList as $seller)
                                <tr>
                                    <td class="px-4 py-3 text-primary-900">
                                        {{ $seller->nama_toko ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-primary-700">
                                        {{ $seller->kategori_produk ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-primary-700">
                                        {{ optional($seller->user)->name ?? ($seller->nama_pemilik ?? $seller->nama ?? '-') }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">
                                            Approved
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        {{-- =================================================== --}}
        {{-- 3. Seller yang Ditolak                             --}}
        {{-- =================================================== --}}
        <div class="bg-white rounded-2xl shadow-sm border border-primary-100 p-6 mb-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-primary-900">
                    Seller yang Ditolak
                </h2>
                <span class="text-sm text-primary-500">
                    Total: {{ $rejectedSellerList->count() }} seller rejected
                </span>
            </div>

            @if ($rejectedSellerList->isEmpty())
                <p class="text-sm text-primary-500 mt-4">
                    Belum ada pendaftaran seller yang ditolak.
                </p>
            @else
                <div class="mt-6 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-primary-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-primary-700 font-medium">Nama Toko</th>
                                <th class="px-4 py-2 text-left text-primary-700 font-medium">Kategori</th>
                                <th class="px-4 py-2 text-left text-primary-700 font-medium">Pemilik</th>
                                <th class="px-4 py-2 text-left text-primary-700 font-medium">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-primary-100">
                            @foreach ($rejectedSellerList as $seller)
                                <tr>
                                    <td class="px-4 py-3 text-primary-900">
                                        {{ $seller->nama_toko ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-primary-700">
                                        {{ $seller->kategori_produk ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-primary-700">
                                        {{ optional($seller->user)->name ?? ($seller->nama_pemilik ?? $seller->nama ?? '-') }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex px-2 py-1 text-xs rounded-full bg-red-100 text-red-700">
                                            Rejected
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
