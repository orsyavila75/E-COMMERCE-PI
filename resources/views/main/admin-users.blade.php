@extends('template.admin-layout')

@section('title', 'Manajemen Pengguna')
@section('header', 'Daftar Pengguna')

@section('content')
<div class="glass-card rounded-2xl overflow-hidden">
    <div class="p-6 border-b border-white/5 flex justify-between items-center">
        <h3 class="font-display text-lg font-bold text-white tracking-wide">Semua Pengguna</h3>
        <div class="flex gap-3">
            <button class="px-4 py-2 bg-white/5 text-stone-300 rounded-lg text-sm font-medium hover:bg-white/10 transition-colors border border-white/5 hover:text-white">
                <i data-lucide="filter" class="w-4 h-4 inline mr-2"></i> Filter
            </button>
            <button class="px-4 py-2 bg-orange-600 text-white rounded-lg text-sm font-medium hover:bg-orange-700 transition-colors shadow-lg shadow-orange-600/20">
                <i data-lucide="download" class="w-4 h-4 inline mr-2"></i> Export Data
            </button>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-white/5 text-stone-400 text-xs uppercase tracking-wider font-medium">
                <tr>
                    <th class="px-6 py-4">Nama</th>
                    <th class="px-6 py-4">Email</th>
                    <th class="px-6 py-4">Role</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                <!-- Dummy Data 1 -->
                <tr class="hover:bg-white/5 transition-colors group">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center text-white font-bold text-xs shadow-lg">RM</div>
                            <span class="font-medium text-stone-200 group-hover:text-white transition-colors">Rina Maharani</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-stone-400 font-light">rina@example.com</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 bg-blue-500/10 text-blue-400 rounded-full text-xs font-medium border border-blue-500/20">Customer</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 bg-green-500/10 text-green-400 rounded-full text-xs font-medium border border-green-500/20 flex w-fit items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                            Aktif
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button class="text-stone-500 hover:text-white transition-colors p-2 hover:bg-white/10 rounded-lg">
                            <i data-lucide="more-horizontal" class="w-5 h-5"></i>
                        </button>
                    </td>
                </tr>
                <!-- Dummy Data 2 -->
                <tr class="hover:bg-white/5 transition-colors group">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-orange-500 to-orange-700 flex items-center justify-center text-white font-bold text-xs shadow-lg">GA</div>
                            <span class="font-medium text-stone-200 group-hover:text-white transition-colors">Galeri Anyaman</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-stone-400 font-light">anyaman@nusantara.com</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 bg-orange-500/10 text-orange-400 rounded-full text-xs font-medium border border-orange-500/20">Seller</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 bg-green-500/10 text-green-400 rounded-full text-xs font-medium border border-green-500/20 flex w-fit items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                            Aktif
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button class="text-stone-500 hover:text-white transition-colors p-2 hover:bg-white/10 rounded-lg">
                            <i data-lucide="more-horizontal" class="w-5 h-5"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div class="p-4 border-t border-white/5 flex justify-between items-center bg-black/20">
        <span class="text-sm text-stone-500">Menampilkan 1-10 dari 1,248 pengguna</span>
        <div class="flex gap-2">
            <button class="px-3 py-1.5 border border-white/10 rounded-lg text-sm text-stone-400 hover:bg-white/5 hover:text-white transition-colors disabled:opacity-50">Previous</button>
            <button class="px-3 py-1.5 border border-white/10 rounded-lg text-sm text-stone-400 hover:bg-white/5 hover:text-white transition-colors">Next</button>
        </div>
    </div>
</div>
@endsection
