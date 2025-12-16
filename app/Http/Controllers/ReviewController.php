<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'id_produk' => 'required|exists:produk,id_produk',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500',
        ]);

        // Assuming id_customer is same as id_user based on AuthController logic
        $customerId = Auth::id();

        // Verify customer exists (optional but good for safety)
        $exists = DB::table('customer')->where('id_customer', $customerId)->exists();
        if (!$exists) {
             return back()->withErrors(['msg' => 'Anda harus terdaftar sebagai customer untuk memberikan ulasan.']);
        }

        DB::table('ulasan')->insert([
            'id_customer' => $customerId,
            'id_produk' => $request->id_produk,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Terima kasih atas ulasan Anda!');
    }
}
