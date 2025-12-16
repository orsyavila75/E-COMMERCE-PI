<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SellerAccountController extends Controller
{
    public function index()
    {
        $seller = Seller::where('id_seller', Auth::id())->first();
        return view('main.edit-account', compact('seller'));
    }

    public function uploadLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg|max:2048', // 2MB max
        ]);

        $seller = Seller::where('id_seller', Auth::id())->firstOrFail();

        // Delete old logo if exists
        if ($seller->logo_toko && Storage::disk('public')->exists($seller->logo_toko)) {
            Storage::disk('public')->delete($seller->logo_toko);
        }

        // Store new logo
        $path = $request->file('logo')->store('seller-logos', 'public');

        // Update seller logo
        $seller->update(['logo_toko' => $path]);

        return back()->with('success', 'Logo toko berhasil diupload!');
    }

    public function deleteLogo()
    {
        $seller = Seller::where('id_seller', Auth::id())->firstOrFail();

        if ($seller->logo_toko) {
            // Delete from storage
            if (Storage::disk('public')->exists($seller->logo_toko)) {
                Storage::disk('public')->delete($seller->logo_toko);
            }

            // Update database
            $seller->update(['logo_toko' => null]);

            return back()->with('success', 'Logo toko berhasil dihapus!');
        }

        return back()->with('error', 'Tidak ada logo untuk dihapus.');
    }
}
