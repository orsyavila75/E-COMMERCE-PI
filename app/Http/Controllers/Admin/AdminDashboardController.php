<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Seller;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Total customer
        $totalCustomers = User::where('role', 'customer')->count();

        // Total seller (semua status)
        $totalSellers = Seller::count();

        // Seller pending
        $pendingSellers = Seller::where('status', 'pending')->count();

        // Daftar seller per status
        $pendingSellerList  = Seller::where('status', 'pending')->get();
        $approvedSellerList = Seller::where('status', 'approved')->get();
        $rejectedSellerList = Seller::where('status', 'rejected')->get();

        return view('main.admin-dashboard', compact(
            'totalCustomers',
            'totalSellers',
            'pendingSellers',
            'pendingSellerList',
            'approvedSellerList',
            'rejectedSellerList'
        ));
    }
}
