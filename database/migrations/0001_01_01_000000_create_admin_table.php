<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->id('id_admin');
            $table->string('email', 100)->unique();
            $table->string('password', 255);
            $table->string('nama_admin', 150);
            $table->rememberToken();
            // tidak pakai timestamps
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin');
    }
};
