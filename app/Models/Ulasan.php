<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ulasan extends Model
{
    protected $table = 'ulasan';
    protected $primaryKey = 'id_ulasan';

    protected $fillable = [
        'id_produk','id_customer','rating','comment'
    ];

    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'id_customer', 'id_customer');
    }
}
