<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('seller', function (Blueprint $table) {
            // sesuaikan posisi "after" dengan kolom yang ada di tabelmu
            $table->string('kategori')->nullable()->after('nama_toko');
        });
    }

    public function down(): void
    {
        Schema::table('seller', function (Blueprint $table) {
            $table->dropColumn('kategori');
        });
    }
};
