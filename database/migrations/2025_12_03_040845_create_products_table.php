<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // Nama produk
            $table->string('name');

            // Slug unik untuk URL (misal: rak-buku)
            $table->string('slug')->unique();

            // Harga (dalam rupiah, pakai integer)
            $table->integer('price');

            // Stok produk
            $table->integer('stock')->default(0);

            // Kategori (Anyaman, Ukiran, Batik, dll)
            $table->string('category')->nullable();

            // Nama file/path gambar produk
            $table->string('image')->nullable();

            // Deskripsi produk (opsional)
            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
