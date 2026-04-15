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
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            
            // 1. Relasi ke tabel users (ini aman karena nama tabel bawaan laravel memang users)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // 2. Relasi ke tabel buku (Kita sebutkan nama tabelnya secara manual di dalam constrained)
            $table->foreignId('buku_id')->constrained('buku')->onDelete('cascade');
            
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali')->nullable(); // Tanggal saat siswa mengembalikan buku
            $table->enum('status', ['dipinjam', 'dikembalikan'])->default('dipinjam');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};