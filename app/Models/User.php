<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_user';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'name','email','password','no_telepon','alamat','role'
    ];

    protected $hidden = [
        'password','remember_token'
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // kalau role seller → ada 1 data di tabel seller
    public function seller(): HasOne
    {
        return $this->hasOne(Seller::class, 'id_seller', 'id_user');
        // id_seller di tabel seller = id_user dari users
    }

    // kalau role customer → ada 1 data di tabel customer
    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class, 'id_customer', 'id_user');
        // id_customer di tabel customer = id_user dari users
    }
}
