<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;

    protected $table = 'seller';  // pastikan ini sesuai dengan nama tabel di DB
    protected $primaryKey = 'id_seller';
    public $incrementing = false;  // kalau id_seller diisi dari users.id
    protected $keyType = 'int';

    // Nonaktifkan timestamps
    public $timestamps = false;

    protected $fillable = [
        'id_seller',
        'nama',
        'no_telepon',
        'email',
        'nama_toko',
        'deskripsi_toko',
        'alamat_pengiriman',
        'kategori_produk',
        'logo_toko',
        'status',
    ];
}
