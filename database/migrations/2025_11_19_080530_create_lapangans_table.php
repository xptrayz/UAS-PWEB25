<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lapangans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->enum('jenis', ['Sintetis', 'Vinyl', 'Rumput Asli']);
            $table->decimal('harga_per_jam', 10, 2);
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['Tersedia', 'Dalam Perbaikan', 'Tidak Aktif'])->default('Tersedia');
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lapangans');
    }
};