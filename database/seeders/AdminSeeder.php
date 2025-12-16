<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Seed default admin account.
     * Admin tidak perlu registrasi, dibuat default oleh sistem.
     */
    public function run(): void
    {
        DB::table('admin')->upsert([
            [
'email' => 'admin@example.com',
'password' => Hash::make('admin123'),
'nama_admin' => 'Administrator',

            ],
        ], ['email'], ['password', 'nama_admin']);
    }
}
