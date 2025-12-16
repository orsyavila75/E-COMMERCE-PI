<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pemesanan extends Model
{
    protected $table = 'pemesanan';
    protected $primaryKey = 'id_pesan';

    protected $fillable = [
        'id_customer','tanggal_pesan','jumlah_barang','total_harga','status_pemesanan'
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'id_customer', 'id_customer');
    }

    public function detail(): HasMany
    {
        return $this->hasMany(DetailPemesanan::class, 'id_pesan', 'id_pesan');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_pesan', 'id_pesan');
    }
}
