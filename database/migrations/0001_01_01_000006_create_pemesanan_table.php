<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pemesanan', function (Blueprint $table) {
            $table->id('id_pesan');

            $table->unsignedBigInteger('id_customer');

            $table->dateTime('tanggal_pesan');
            $table->integer('jumlah_barang');
            $table->decimal('total_harga', 18, 2);

            $table->enum('status_pemesanan', ['baru','diproses','dikirim','selesai','batal'])
                  ->default('baru');

            $table->foreign('id_customer')
                ->references('id_customer')->on('customer')
                ->cascadeOnDelete();

            $table->timestamps(); // ✅ cocok
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemesanan');
    }
};
