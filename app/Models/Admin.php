<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'admin';        // nama tabel di DB
    protected $primaryKey = 'id_admin';// primary key di tabel kamu

    public $incrementing = true;
    public $timestamps = false;        // set true kalau tabel punya created_at/updated_at

    protected $fillable = [
        'email',
        'password',
        'nama_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
