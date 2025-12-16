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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            // relasi ke tabel orders
            $table->foreignId('order_id')
                  ->constrained('orders')
                  ->onDelete('cascade');

            // kolom yang dipakai di OrderController
            $table->string('product_name');
            $table->unsignedInteger('qty');
            $table->unsignedBigInteger('total');

            // optional (boleh tidak dipakai sekarang)
            $table->string('product_slug')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('price')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
