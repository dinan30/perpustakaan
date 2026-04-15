<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'buku';

    /**
     * Kolom yang dapat diisi secara massal (Mass Assignment).
     * Pastikan 'kategori' sudah ada di sini agar tidak error saat simpan data.
     */
    protected $fillable = [
        'judul', 
        'penulis', 
        'penerbit', 
        'kategori', 
        'tahun_terbit', 
        'stok'
    ];

    /**
     * Casting tipe data.
     * Opsional: Memastikan stok dan tahun selalu dibaca sebagai angka (integer).
     */
    protected $casts = [
        'tahun_terbit' => 'integer',
        'stok' => 'integer',
    ];

    /**
     * Relasi ke Tabel Transaksi.
     * Satu buku bisa memiliki banyak riwayat transaksi peminjaman.
     */
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'buku_id');
    }
}