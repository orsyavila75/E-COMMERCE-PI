<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Seed data customer.
     */
    public function run(): void
    {
        DB::table('users')->upsert([
            [
                'name' => 'Rina Maharani',
                'email' => 'rina@gmail.com',
                'password' => Hash::make('password'),
                'no_telepon' => '081222333444',
                'alamat' => 'Jl. Kaliurang Km 7, Sleman, Yogyakarta',
                'role' => 'customer',
            ],
            [
                'name' => 'Yoga Prasetyo',
                'email' => 'yoga@gmail.com',
                'password' => Hash::make('password'),
                'no_telepon' => '081333444555',
                'alamat' => 'Jl. Parangtritis No.18, Bantul, Yogyakarta',
                'role' => 'customer',
            ],
            [
                'name' => 'Sari Puspita',
                'email' => 'sari@gmail.com',
                'password' => Hash::make('password'),
                'no_telepon' => '081444555666',
                'alamat' => 'Jl. Malioboro No.22, Kota Yogyakarta',
                'role' => 'customer',
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi@gmail.com',
                'password' => Hash::make('password'),
                'no_telepon' => '081555666777',
                'alamat' => 'Jl. Wates Km 10, Kulon Progo, Yogyakarta',
                'role' => 'customer',
            ],
            [
                'name' => 'Agus Saputra',
                'email' => 'agus@gmail.com',
                'password' => Hash::make('password'),
                'no_telepon' => '081666777888',
                'alamat' => 'Jl. Imogiri Timur No.15, Bantul, Yogyakarta',
                'role' => 'customer',
            ],
            [
                'name' => 'Ratna Kartika',
                'email' => 'ratna@gmail.com',
                'password' => Hash::make('password'),
                'no_telepon' => '082222333444',
                'alamat' => 'Jl. Prawirotaman No.12, Kota Yogyakarta',
                'role' => 'customer',
            ],
        ], ['email'], ['name', 'password', 'no_telepon', 'alamat', 'role']);
    }
}
