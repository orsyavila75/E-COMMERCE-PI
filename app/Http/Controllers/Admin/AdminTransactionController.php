<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use Illuminate\Http\Request;

class AdminTransactionController extends Controller
{
    public function index()
    {
        // Fetch all transactions - simplified query
        $transactions = Pemesanan::orderBy('tanggal_pesan', 'desc')
            ->paginate(15);

        return view('main.admin-transactions', compact('transactions'));
    }
}
