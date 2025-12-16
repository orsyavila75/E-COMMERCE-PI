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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // relasi ke users
            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // kode pesanan, misal: ORD-20251203052115-514
            $table->string('code')->unique();

            // status pesanan, contoh: pending_payment, paid, cancelled, dll
            $table->string('status')->default('pending_payment');

            // metode pembayaran: transfer_bank, e_wallet, cod
            $table->string('payment_method');

            // info bank (kalau transfer bank)
            $table->string('bank_name')->nullable();      // bca / bri / bni / mandiri
            $table->string('e_wallet_name')->nullable();  // gopay / ovo / dll

            // nomor VA / rekening tujuan
            $table->string('payment_va')->nullable();

            // nama pemilik rekening yang ditampilkan
            $table->string('payment_owner')->nullable();

            // ringkasan nominal
            $table->unsignedBigInteger('subtotal')->default(0);
            $table->unsignedBigInteger('shipping_cost')->default(0);
            $table->unsignedBigInteger('discount')->default(0);
            $table->unsignedBigInteger('total')->default(0);

            // batas waktu pembayaran (misalnya 1x24 jam)
            $table->timestamp('expires_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
