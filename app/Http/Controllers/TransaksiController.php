<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\User;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /**
     * Menampilkan daftar transaksi (Penyebab error Method index does not exist)
     */
    public function index()
    {
        // Mengambil data transaksi dengan relasi user dan buku
        $transaksi = Transaksi::with(['user', 'buku'])->latest()->get();
        return view('admin.transaksi.index', compact('transaksi'));
    }

    /**
     * Form Tambah Transaksi
     */
    public function create()
    {
        $users = User::all(); 
        $buku = Buku::where('stok', '>', 0)->get();

        return view('admin.transaksi.create', compact('users', 'buku'));
    }

    /**
     * Simpan Transaksi Baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'buku_id' => 'required|exists:buku,id',
            'tgl_pinjam' => 'required|date',
            'tgl_kembali' => 'required|date|after_or_equal:tgl_pinjam',
        ]);

        $dataBuku = Buku::findOrFail($request->buku_id);

        if ($dataBuku->stok <= 0) {
            return back()->with('error', 'Stok buku habis!');
        }

        // Simpan ke database sesuai kolom di migration lo
        Transaksi::create([
            'user_id' => $request->user_id,
            'buku_id' => $request->buku_id,
            'tanggal_pinjam' => $request->tgl_pinjam,
            'tanggal_kembali' => $request->tgl_kembali,
            'status' => 'pinjam',
            'denda' => 0,
        ]);

        // Kurangi stok
        $dataBuku->decrement('stok');

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil ditambahkan!');
    }
}