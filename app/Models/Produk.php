<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produk extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'id_produk';

    protected $fillable = [
        'id_seller','nama_produk','jenis_produk','deskripsi',
        'harga','stok','gambar','rating'
    ];

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class, 'id_seller', 'id_seller');
    }

    public function ulasan(): HasMany
    {
        return $this->hasMany(Ulasan::class, 'id_produk', 'id_produk');
    }

    public function detailPemesanan(): HasMany
    {
        return $this->hasMany(DetailPemesanan::class, 'id_produk', 'id_produk');
    }
}
