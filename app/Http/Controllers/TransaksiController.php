<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\User;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::with(['user', 'buku'])->latest()->get();
        return view('admin.transaksi.index', compact('transaksi'));
    }

    public function create()
    {
        $users = User::all(); 
        $buku = Buku::where('stok', '>', 0)->get();
        return view('admin.transaksi.create', compact('users', 'buku'));
    }

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

        Transaksi::create([
            'user_id' => $request->user_id,
            'buku_id' => $request->buku_id,
            'tanggal_pinjam' => $request->tgl_pinjam,
            'tanggal_kembali' => $request->tgl_kembali,
            'status' => 'pinjam',
            'denda' => 0,
        ]);

        $dataBuku->decrement('stok');

        return redirect()->route('transaksi.index')->with('success', 'Peminjaman berhasil dicatat!');
    }

    public function kembali($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        if ($transaksi->status === 'pinjam') {
            $transaksi->update(['status' => 'kembali']);

            $buku = Buku::find($transaksi->buku_id);
            if ($buku) {
                $buku->increment('stok');
            }

            return redirect()->route('transaksi.index')->with('success', 'Buku berhasil dikembalikan.');
        }

        return redirect()->route('transaksi.index')->with('error', 'Buku sudah dikembalikan.');
    }

    public function setujui($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        if ($transaksi->status === 'menunggu') {
            $transaksi->update(['status' => 'pinjam']);
            return redirect()->route('transaksi.index')->with('success', 'Peminjaman disetujui.');
        }

        return redirect()->route('transaksi.index')->with('error', 'Transaksi tidak dapat disetujui.');
    }

    public function tolak($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        if ($transaksi->status === 'menunggu') {
            $transaksi->update(['status' => 'ditolak']);

            // Kembalikan stok buku
            $buku = Buku::find($transaksi->buku_id);
            if ($buku) {
                $buku->increment('stok');
            }

            return redirect()->route('transaksi.index')->with('success', 'Peminjaman ditolak.');
        }

        return redirect()->route('transaksi.index')->with('error', 'Transaksi tidak dapat ditolak.');
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        // Jika transaksi masih berstatus "pinjam" atau "menunggu", kita harus mengembalikan stok bukunya terlebih dahulu
        if (in_array($transaksi->status, ['pinjam', 'menunggu'])) {
            $buku = Buku::find($transaksi->buku_id);
            if ($buku) {
                $buku->increment('stok');
            }
        }

        $transaksi->delete();

        return redirect()->route('transaksi.index')->with('success', 'Data transaksi berhasil dihapus.');
    }
}