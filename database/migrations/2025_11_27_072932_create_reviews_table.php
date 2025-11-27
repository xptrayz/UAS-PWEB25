<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('lapangan_id')->constrained('lapangans')->onDelete('cascade');
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->integer('rating')->comment('1-5 stars');
            $table->text('komentar')->nullable();
            $table->timestamps();
            
            
            $table->unique(['user_id', 'booking_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};