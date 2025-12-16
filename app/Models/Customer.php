<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customer';
    protected $primaryKey = 'id_customer';
    public $incrementing = false;
    protected $keyType = 'int';

    public $timestamps = false; // kalau tabel customer tanpa timestamps

    protected $fillable = [
        'id_customer',
        'nama_customer',
        'no_telepon',
        'alamat',
    ];
}
