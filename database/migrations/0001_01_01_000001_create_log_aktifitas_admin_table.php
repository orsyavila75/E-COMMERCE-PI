<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('log_aktifitas_admin', function (Blueprint $table) {
            $table->id('id_log');

            $table->unsignedBigInteger('id_admin');
            $table->string('email', 100);
            $table->string('password', 255);
            $table->string('nama_admin', 150);
            $table->text('aktivitas');
            $table->timestamp('waktu_aktivitas')->useCurrent();

            $table->foreign('id_admin')
                ->references('id_admin')->on('admin')
                ->cascadeOnDelete();

            // tidak pakai timestamps karena sudah ada waktu_aktivitas
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_aktifitas_admin');
    }
};
