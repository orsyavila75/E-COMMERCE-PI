<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('customer', function (Blueprint $table) {
            $table->id('id_customer');
            $table->string('nama_customer', 150);
            $table->string('no_telepon', 30);
            $table->text('alamat');
            // tidak pakai timestamps
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer');
    }
};
