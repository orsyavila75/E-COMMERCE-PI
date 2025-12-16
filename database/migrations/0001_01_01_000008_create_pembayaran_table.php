<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id('id_pembayaran');

            $table->unsignedBigInteger('id_pesan');

            $table->string('metode_pembayaran', 100);
            $table->dateTime('tanggal_pembayaran')->nullable();
            $table->decimal('total_bayar', 18, 2);

            $table->enum('status_pembayaran', ['menunggu','berhasil','gagal'])
                  ->default('menunggu');

            $table->foreign('id_pesan')
                ->references('id_pesan')->on('pemesanan')
                ->cascadeOnDelete();

            $table->timestamps(); // ✅ cocok
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
