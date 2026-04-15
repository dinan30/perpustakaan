<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;

class PerpustakaanController extends Controller
{
    /**
     * Dashboard untuk Admin, Super Admin, dan Operator.
     * Menampilkan statistik keseluruhan dan semua riwayat peminjaman untuk dipantau.
     */
    public function adminDashboard()
    {
        // Proteksi: Siswa tidak boleh akses dashboard admin
        if (Auth::user()->role === 'siswa') {
            return redirect()->route('siswa.dashboard');
        }

        $data = [
            'total_buku' => Buku::count(),
            'total_pinjam' => Transaksi::where('status', 'pinjam')->count(),
            'transaksi_terbaru' => Transaksi::with(['user', 'buku'])
                ->latest()
                ->get() // Admin bisa melihat semua data untuk monitoring
        ];

        return view('admin.dashboard', $data);
    }

    /**
     * Dashboard khusus untuk Siswa.
     * Siswa dapat melihat daftar buku yang tersedia untuk dipinjam dan riwayat mereka sendiri.
     */
    public function siswaDashboard()
    {
        // Proteksi: Admin diarahkan ke dashboard admin
        if (Auth::user()->role !== 'siswa') {
            return redirect()->route('admin.dashboard');
        }

        // Ambil riwayat peminjaman milik siswa yang login
        $pinjamanSaya = Transaksi::with('buku')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        // Ambil daftar buku yang stoknya masih tersedia untuk dipinjam
        $semuaBuku = Buku::where('stok', '>', 0)->get();

        return view('siswa.dashboard', compact('pinjamanSaya', 'semuaBuku'));
    }

    /**
     * Fitur Peminjaman Buku (Dilakukan oleh Siswa)
     */
    public function store_peminjaman(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:buku,id', // Pastikan nama tabel benar (bukus/buku)
        ]);

        $buku = Buku::findOrFail($request->buku_id);

        // Validasi stok buku
        if ($buku->stok <= 0) {
            return back()->with('error', 'Maaf, stok buku ini sudah habis.');
        }

        // Simpan data transaksi baru
        Transaksi::create([
            'user_id' => Auth::id(),
            'buku_id' => $request->buku_id,
            'tanggal_pinjam' => now()->toDateString(),
            'tanggal_kembali' => now()->addDays(7)->toDateString(), // Batas waktu otomatis 7 hari
            'status' => 'pinjam',
            'denda' => 0
        ]);

        // Kurangi stok buku secara otomatis
        $buku->decrement('stok');

        return redirect()->route('siswa.dashboard')->with('success', 'Buku berhasil dipinjam! Silahkan ambil di perpustakaan.');
    }

    /**
     * Fitur Pengembalian Buku (Dilakukan oleh Siswa)
     */
    public function kembalikanBuku($id)
    {
        // Cari transaksi milik siswa yang login
        $transaksi = Transaksi::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($transaksi->status === 'kembali') {
            return back()->with('error', 'Buku ini sudah Anda kembalikan sebelumnya.');
        }

        // Update status transaksi
        $transaksi->update([
            'status' => 'kembali'
        ]);

        // Kembalikan stok buku secara otomatis
        Buku::find($transaksi->buku_id)->increment('stok');

        return back()->with('success', 'Terima kasih! Buku telah dikembalikan.');
    }

    public function peminjaman()
    {
        // Ambil semua data buku buat ditampilin di dropdown select
        $semuaBuku = Buku::where('stok', '>', 0)->get();

        // Oper datanya ke view peminjaman
        return view('siswa.peminjaman', compact('semuaBuku'));
    }

    public function riwayatPeminjaman()
    {
        $pinjamanSaya = Transaksi::with('buku')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('siswa.riwayat', compact('pinjamanSaya'));
    }
}