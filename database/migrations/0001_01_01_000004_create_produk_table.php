<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id('id_produk');

            $table->unsignedBigInteger('id_seller');

            $table->string('nama_produk', 200);
            $table->string('jenis_produk', 100);
            $table->text('deskripsi')->nullable();
            $table->decimal('harga', 18, 2);
            $table->integer('stok');
            $table->string('gambar', 300)->nullable();

            // rating hasil hitung dari ulasan (boleh null)
            $table->float('rating')->nullable();

            $table->foreign('id_seller')
                ->references('id_seller')->on('seller')
                ->cascadeOnDelete();

            $table->timestamps(); // ✅ cocok
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
