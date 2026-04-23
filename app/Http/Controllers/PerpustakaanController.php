<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;

class PerpustakaanController extends Controller
{
    // Dashboard Admin
    public function adminDashboard()
    {
        if (Auth::user()->role === 'siswa') {
            return redirect()->route('siswa.dashboard');
        }

        $data = [
            'total_buku' => Buku::count(),
            'total_pinjam' => Transaksi::whereIn('status', ['pinjam', 'menunggu_kembali'])->count(),
            'transaksi_terbaru' => Transaksi::with(['user', 'buku'])->latest()->take(10)->get()
        ];

        return view('admin.dashboard', $data);
    }

    // Dashboard Siswa
    public function siswaDashboard()
    {
        if (Auth::user()->role !== 'siswa') {
            return redirect()->route('admin.dashboard');
        }

        $pinjamanSaya = Transaksi::with('buku')->where('user_id', Auth::id())->latest()->get();
        $totalDenda = $pinjamanSaya->sum('denda');
        $transaksiBerdenda = $pinjamanSaya->where('denda', '>', 0)->count();

        return view('siswa.dashboard', compact('pinjamanSaya', 'totalDenda', 'transaksiBerdenda'));
    }

    // Form Peminjaman
    public function peminjaman()
    {
        $semuaBuku = Buku::where('stok', '>', 0)->get();
        return view('siswa.peminjaman', compact('semuaBuku'));
    }

    // Proses Simpan Pinjam
    public function store_peminjaman(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:buku,id',
        ]);

        $buku = Buku::findOrFail($request->buku_id);

        if ($buku->stok <= 0) {
            return back()->with('error', 'Maaf, stok buku ini sudah habis.');
        }

        Transaksi::create([
            'user_id' => Auth::id(),
            'buku_id' => $request->buku_id,
            'tanggal_pinjam' => now()->toDateString(),
            'tanggal_kembali' => now()->addDays(7)->toDateString(),
            'status' => 'menunggu',
            'denda' => 0
        ]);

        // Stok tidak dikurangi di sini, stok baru dikurangi saat admin menyetujui peminjaman

        return redirect()->route('siswa.riwayat')->with('success', 'Peminjaman buku ' . $buku->judul . ' sedang menunggu persetujuan admin!');
    }

    // Riwayat Peminjaman Siswa
    public function riwayatPeminjaman()
    {
        $pinjamanSaya = Transaksi::with('buku')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('siswa.riwayat', compact('pinjamanSaya'));
    }

    // Pengembalian Buku
    public function kembalikanBuku($id)
    {
        $transaksi = Transaksi::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        if ($transaksi->status === 'kembali' || $transaksi->status === 'menunggu_kembali') {
            return back()->with('error', 'Buku ini sudah dalam proses pengembalian atau sudah dikembalikan.');
        }

        $transaksi->update(['status' => 'menunggu_kembali']);
        // Stok buku tidak ditambahkan di sini, tunggu verifikasi dari Admin

        return back()->with('success', 'Terima kasih! Pengembalian buku sedang menunggu verifikasi admin.');
    }
}