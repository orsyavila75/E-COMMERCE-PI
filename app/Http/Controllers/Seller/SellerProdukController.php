<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Produk;
use Illuminate\Http\Request;

class SellerProductController extends Controller
{
    public function create()
    {
        return view('seller.products.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image_url' => 'nullable|url',
        ]);

        $data['seller_id'] = auth()->id();
        Produk::create($data);

        return redirect()->route('seller.dashboard')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    public function show(Produk $product)
    {
        abort_if($product->seller_id !== auth()->id(), 403);
        return view('seller.products.show', compact('product'));
    }

    public function destroy(Produk $product)
    {
        abort_if($product->seller_id !== auth()->id(), 403);
        $product->delete();

        return back()->with('success', 'Produk berhasil dihapus.');
    }
}
