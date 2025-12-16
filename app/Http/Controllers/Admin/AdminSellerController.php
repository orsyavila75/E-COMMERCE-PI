<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seller;

class AdminSellerController extends Controller
{
    // Setujui pendaftaran seller
    public function approve(Seller $seller)
    {
        // ganti 'approved' dengan nilai yang kamu pakai di DB kalau beda
        $seller->status = 'approved';
        $seller->save();

        return back()->with('success', 'Seller berhasil disetujui.');
    }

    // Tolak pendaftaran seller
    public function reject(Seller $seller)
    {
        // ganti 'rejected' dengan nilai yang kamu pakai di DB kalau beda
        $seller->status = 'rejected';
        $seller->save();

        return back()->with('success', 'Pendaftaran seller ditolak.');
    }
}
