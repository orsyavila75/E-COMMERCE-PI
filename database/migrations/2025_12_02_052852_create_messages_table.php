<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('messages', function (Blueprint $table) {
        $table->id();  // Menambahkan primary key
        $table->unsignedBigInteger('sender_id');  // ID pengirim (customer atau seller)
        $table->unsignedBigInteger('receiver_id'); // ID penerima
        $table->text('message');  // Isi pesan
        $table->timestamps();  // created_at, updated_at

        // Menghubungkan ke tabel users untuk sender dan receiver
        $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
