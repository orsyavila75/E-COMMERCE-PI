<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ulasan', function (Blueprint $table) {
            $table->id('id_ulasan');

            $table->unsignedBigInteger('id_produk');
            $table->unsignedBigInteger('id_customer');

            $table->tinyInteger('rating'); // 1-5
            $table->text('comment')->nullable();

            $table->foreign('id_produk')
                ->references('id_produk')->on('produk')
                ->cascadeOnDelete();

            $table->foreign('id_customer')
                ->references('id_customer')->on('customer')
                ->cascadeOnDelete();

            $table->unique(['id_produk','id_customer']);

            $table->timestamps(); // ✅ cocok
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ulasan');
    }
};
