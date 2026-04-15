<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Buku;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon; // Penting untuk perhitungan denda

class TransaksiController extends Controller
{
    public function index()
    {
        // Mengambil data transaksi beserta relasi user dan buku
        $transaksi = Transaksi::with(['user', 'buku'])->latest()->get();
        return view('admin.transaksi.index', compact('transaksi'));
    }

    public function create()
    {
        // Hanya menampilkan user dengan role siswa dan buku yang stoknya masih ada
        $users = User::where('role', 'siswa')->get();
        $buku = Buku::where('stok', '>', 0)->get();
        return view('admin.transaksi.create', compact('users', 'buku'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'buku_id' => 'required|exists:buku,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        // 1. Simpan Transaksi Baru
        Transaksi::create($request->all());

        // 2. Kurangi Stok Buku
        $buku = Buku::find($request->buku_id);
        $buku->decrement('stok');

        return redirect()->route('transaksi.index')->with('success', 'Peminjaman buku berhasil dicatat!');
    }

    public function edit(Transaksi $transaksi)
    {
        return view('admin.transaksi.edit', compact('transaksi'));
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        /**
         * LOGIKA PENGEMBALIAN BUKU & PERHITUNGAN DENDA
         * Terpicu jika request tidak mengandung 'tanggal_pinjam' (berasal dari tombol Kembalikan di index)
         */
        if (!$request->has('tanggal_pinjam')) {
            $tgl_kembali_seharusnya = Carbon::parse($transaksi->tanggal_kembali)->startOfDay();
            $tgl_sekarang = Carbon::now()->startOfDay();
            $denda = 0;
            $tarif_denda = 10000; // Rp 1.000 per hari keterlambatan

            // Hitung selisih jika hari ini melewati batas kembali
            if ($tgl_sekarang->gt($tgl_kembali_seharusnya)) {
                $selisih_hari = $tgl_sekarang->diffInDays($tgl_kembali_seharusnya);
                $denda = $selisih_hari * $tarif_denda;
            }

            // Update status, denda, dan tambahkan stok buku kembali
            $transaksi->update([
                'status' => 'kembali',
                'denda' => $denda
            ]);

            $transaksi->buku->increment('stok');

            $pesan = $denda > 0 
                ? "Buku berhasil dikembalikan. Terlambat {$selisih_hari} hari, denda: Rp " . number_format($denda, 0, ',', '.') 
                : "Buku berhasil dikembalikan tepat waktu.";

            return redirect()->route('transaksi.index')->with('success', $pesan);
        }

        /**
         * LOGIKA UPDATE DATA (Dari halaman Edit)
         */
        $transaksi->update($request->all());
        return redirect()->route('transaksi.index')->with('success', 'Data transaksi berhasil diperbarui!');
    }

    public function destroy(Transaksi $transaksi)
    {
        // Jika data dihapus tapi buku belum balik, stok harus dipulihkan
        if ($transaksi->status == 'pinjam') {
            $transaksi->buku->increment('stok');
        }

        $transaksi->delete();
        return redirect()->route('transaksi.index')->with('success', 'Data transaksi berhasil dihapus!');
    }
}