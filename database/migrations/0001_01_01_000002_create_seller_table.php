<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('seller', function (Blueprint $table) {
            $table->unsignedBigInteger('id_seller'); // sama dg users.id_user
            $table->primary('id_seller');

            $table->string('nama', 150);
            $table->string('no_telepon', 30)->nullable();
            $table->string('email', 190)->unique();

            // fitur seller tambahan (sesuai gambar)
            $table->string('nama_toko', 150)->nullable();
            $table->text('deskripsi_toko')->nullable();
            $table->text('alamat_pengiriman')->nullable();
            $table->string('kategori_produk', 100)->nullable();
            $table->string('logo_toko', 255)->nullable(); // simpan path file

            // kalau kamu TIDAK mau created_at/updated_at di seller
            // jangan pakai timestamps()
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seller');
    }
};
