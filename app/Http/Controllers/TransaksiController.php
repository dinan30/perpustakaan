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

    public function kembali(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        if ($transaksi->status === 'pinjam') {
            // Ambil tanggal pengembalian aktual dari form admin, atau gunakan hari ini jika tidak ada
            $tanggalDikembalikan = $request->input('tanggal_dikembalikan', date('Y-m-d'));

            // Hitung denda jika tanggal dikembalikan melebihi batas tanggal kembali
            $denda = 0;
            $tglBatasKembali = \Carbon\Carbon::parse($transaksi->tanggal_kembali);
            $tglAktualKembali = \Carbon\Carbon::parse($tanggalDikembalikan);

            if ($tglAktualKembali->gt($tglBatasKembali)) {
                // Hitung selisih hari keterlambatan
                $selisihHari = $tglAktualKembali->diffInDays($tglBatasKembali);
                // Denda misalnya Rp 1000 per hari keterlambatan
                $denda = $selisihHari * 10000;
            }

            $transaksi->update([
                'status' => 'kembali',
                'denda' => $denda,
            ]);

            $buku = Buku::find($transaksi->buku_id);
            if ($buku) {
                $buku->increment('stok');
            }

            $pesan = 'Buku berhasil dikembalikan pada tanggal ' . $tanggalDikembalikan . '.';
            if ($denda > 0) {
                $pesan .= ' Terkena denda keterlambatan sebesar Rp ' . number_format($denda, 0, ',', '.') . '.';
            }

            return redirect()->route('transaksi.index')->with('success', $pesan);
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

    public function edit($id)
    {
        $transaksi = Transaksi::with(['user', 'buku'])->findOrFail($id);
        return view('admin.transaksi.edit', compact('transaksi'));
    }

    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $request->validate([
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'status' => 'required|in:menunggu,pinjam,kembali,ditolak',
        ]);

        // Simpan status lama untuk mengecek perubahan stok buku
        $statusLama = $transaksi->status;
        $statusBaru = $request->status;

        $transaksi->update([
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => $statusBaru,
        ]);

        // Logika sederhana untuk manajemen stok jika status berubah
        if ($statusLama != $statusBaru) {
            $buku = Buku::find($transaksi->buku_id);
            if ($buku) {
                // Jika dari pinjam/menunggu berubah menjadi kembali/ditolak -> stok bertambah
                if (in_array($statusLama, ['pinjam', 'menunggu']) && in_array($statusBaru, ['kembali', 'ditolak'])) {
                    $buku->increment('stok');
                }
                // Jika dari kembali/ditolak berubah menjadi pinjam/menunggu -> stok berkurang
                elseif (in_array($statusLama, ['kembali', 'ditolak']) && in_array($statusBaru, ['pinjam', 'menunggu'])) {
                    if ($buku->stok > 0) {
                        $buku->decrement('stok');
                    } else {
                        // Batalkan update jika stok habis
                        $transaksi->update(['status' => $statusLama]);
                        return back()->with('error', 'Stok buku habis! Tidak bisa mengubah status menjadi pinjam/menunggu.');
                    }
                }
            }
        }

        return redirect()->route('transaksi.index')->with('success', 'Data transaksi berhasil diperbarui.');
    }
}