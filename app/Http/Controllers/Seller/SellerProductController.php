<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SellerProductController extends Controller
{
    public function create()
    {
        return view('main.add-product');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'jenis_produk' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:1',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $imagePath = null;
        
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . Str::slug($request->nama_produk) . '.' . $file->getClientOriginalExtension();
            $imagePath = $file->storeAs('products', $filename, 'public');
        }

        // Use Eloquent to create product
        \App\Models\Produk::create([
            'id_seller' => Auth::id(),
            'nama_produk' => $request->nama_produk,
            'jenis_produk' => $request->jenis_produk,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'gambar' => $imagePath,
            'rating' => 0,
        ]);

        return redirect()->route('seller.dashboard')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function show($product)
    {
        $produk = DB::table('produk')->where('id_produk', $product)->first();
        return view('main.add-product', compact('produk'));
    }

    public function edit($product)
    {
        $produk = DB::table('produk')->where('id_produk', $product)->first();
        return view('main.seller-products.edit', ['product' => $produk]);
    }

    public function update(Request $request, $product)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'jenis_produk' => 'nullable|string|max:100',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $updateData = [
            'nama_produk' => $request->nama_produk,
            'jenis_produk' => $request->jenis_produk,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'updated_at' => now(),
        ];

        if ($request->hasFile('gambar')) {
            // Delete old image
            $oldProduct = DB::table('produk')->where('id_produk', $product)->first();
            if ($oldProduct && $oldProduct->gambar) {
                Storage::disk('public')->delete($oldProduct->gambar);
            }

            $file = $request->file('gambar');
            $filename = time() . '_' . Str::slug($request->nama_produk) . '.' . $file->getClientOriginalExtension();
            $updateData['gambar'] = $file->storeAs('products', $filename, 'public');
        }

        DB::table('produk')->where('id_produk', $product)->update($updateData);

        return redirect()->route('seller.dashboard')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy($product)
    {
        $produk = DB::table('produk')->where('id_produk', $product)->first();
        
        if ($produk && $produk->gambar) {
            Storage::disk('public')->delete($produk->gambar);
        }

        DB::table('produk')->where('id_produk', $product)->delete();

        return redirect()->route('seller.dashboard')->with('success', 'Produk berhasil dihapus!');
    }
}
