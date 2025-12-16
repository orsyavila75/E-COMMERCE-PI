<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('detail_pemesanan', function (Blueprint $table) {
            $table->id('id_detail');

            $table->unsignedBigInteger('id_pesan');
            $table->unsignedBigInteger('id_produk');

            $table->integer('qty');
            $table->decimal('harga_satuan', 18, 2);
            $table->decimal('subtotal', 18, 2);

            $table->foreign('id_pesan')
                ->references('id_pesan')->on('pemesanan')
                ->cascadeOnDelete();

            $table->foreign('id_produk')
                ->references('id_produk')->on('produk')
                ->cascadeOnDelete();

            $table->timestamps(); // ✅ kamu minta detail pesanan juga pakai
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_pemesanan');
    }
};
