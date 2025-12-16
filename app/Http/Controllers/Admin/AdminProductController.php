<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Produk::with('seller');

        // Filter by category if provided
        if ($request->has('category') && $request->category !== 'semua') {
            $query->where('kategori', $request->category);
        }

        // Search by product name
        if ($request->has('search') && $request->search !== '') {
            $query->where('nama_produk', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(12);

        return view('main.admin-products', compact('products'));
    }

    public function destroy($id)
    {
        $product = Produk::find($id);
        
        if (!$product) {
            return back()->with('error', 'Produk tidak ditemukan');
        }

        // Delete product image if exists
        if ($product->foto_produk && file_exists(public_path($product->foto_produk))) {
            unlink(public_path($product->foto_produk));
        }

        $product->delete();

        return back()->with('success', 'Produk berhasil dihapus');
    }
}
